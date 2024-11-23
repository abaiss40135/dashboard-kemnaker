<?php

namespace App\Observers;

use App\Helpers\Constants;
use App\Jobs\UpdateAkumulasiLaporanBhabinkamtibmasJob;
use App\Jobs\UpdateKlasterRutinitasBhabinkamtibmasJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Bus;

class LaporanBhabinkamtibmasObserver
{
    public function created(Model $model)
    {
        $this->dispatchJobUpdateAkumulasiAndKlaster();
    }

    public function updated(Model $model)
    {
        //
    }

    public function deleted(Model $model)
    {
        $this->dispatchJobUpdateAkumulasiAndKlaster();
    }

    public function restored(Model $model)
    {
        //
    }

    public function forceDeleted(Model $model)
    {
        //
    }

    private function dispatchJobUpdateAkumulasiAndKlaster()
    {
        $user =  auth()->user();
        Bus::chain([
            new UpdateAkumulasiLaporanBhabinkamtibmasJob($this->countAkumulasiLaporan($user)),
            new UpdateKlasterRutinitasBhabinkamtibmasJob($this->findKlasterRutinitasBhabinkamtibmas($user))
        ])->dispatch();
    }

    private function countAkumulasiLaporan($user)
    {
        $defaultTipeValue = [
            'jumlah_dds'             => 0,
            'jumlah_deteksi_dini'    => 0,
            'jumlah_ps'              => 0,
            'jumlah_ps_eksekutif'    => 0,
            'jumlah_ps_non_sengketa' => 0
        ];

        /**
         * Selang seling tipe dan user_id, ganjil berarti tipe dan genap berarti user_id
         */
        $params = [];
        for ($j = 1; $j <= 10; $j++) {
            $params[] = $j % 2 == 0 ? $user->id : array_keys($defaultTipeValue)[$j/2];
        }
        /**
         * this query only find month period by this year (date(Y))
         */
        $counted = collect(DB::connection("pgsql_read")->select("
            SELECT ? as tipe, count(li.uraian), to_char(dds.created_at, 'YYYY-MM') as periode
            from laporan_informasi li
                     JOIN dds_wargas dds on li.form_id = dds.id
            WHERE dds.user_id = ?
              AND form_type = 'App\Models\Dds_warga'
            group by periode
            UNION
            SELECT ? as tipe, count(li.uraian), to_char(dd.created_at, 'YYYY-MM') as periode
            from laporan_informasi li
                     JOIN deteksi_dinis dd on li.form_id = dd.id
            WHERE dd.user_id = ?
              AND form_type = 'App\Models\Deteksi_dini'
            group by periode
            UNION
            SELECT ? as tipe, count(ps.uraian_kejadian), to_char(ps.created_at, 'YYYY-MM') as periode
            FROM problem_solvings ps
            WHERE ps.user_id = ?
            group by periode
            UNION
            SELECT ? as tipe, count(pse.uraian_kejadian), to_char(pse.created_at, 'YYYY-MM') as periode
            FROM ps_eksekutifs pse
            WHERE pse.user_id = ?
            group by periode
            UNION
            SELECT ? as tipe, count(pns.uraian_masalah), to_char(pns.created_at, 'YYYY-MM') as periode
            FROM ps_non_sengketas pns
            WHERE pns.user_id = ?
            group by periode;
        ", $params));
        $akumulasi_periode = $counted->groupBy('periode')->map(function ($akumulasi, $periode) use ($user, $defaultTipeValue) {
            /**
             * Merging data user dengan hasil perhitungan akumulasi laporan per periode
             *
             * Params 1 data user
             * Params 2 data akumulasi per tipe laporan
             * Params 3 periode (tahun-bulan)
             * Params 4 key kolom database
             */
            return array_merge([
                'user_id'       => $user->id,
                'personel_id'   => $user->personel->personel_id ?? null,
                'periode'       => $periode
            ], $defaultTipeValue, $akumulasi->mapWithKeys(function ($item, $key) {
                return [$item->tipe => $item->count];
            })->toArray());
        })->values()->all();
        return $akumulasi_periode;
    }

    private function findKlasterRutinitasBhabinkamtibmas($user)
    {
        /**
         * user_id, startOfWeek, endOfWeek
         */
        $params = [];
        $date = now();
        for ($j = 1; $j <= 15; $j++) {
            if ($j % 11 == 0 || $j % 8 == 0) {
                $params[] = $date->startOfWeek()->format('Y-m-d H:i:s');
            } else if ($j % 3 == 0) {
                $params[] = $date->endOfWeek()->format('Y-m-d H:i:s');
            } else if ($j % 10 == 0 || $j % 4 == 0) {
                $params[] = $user->id;
            } else if ($j % 5 == 0 || $j % 2 == 0) {
                $params[] = $date->startOfWeek()->format('Y-m-d H:i:s');
            } else {
                $params[] = $user->id;
            }
        }

        $sum = collect(DB::connection("pgsql_read")->select("
            SELECT sum(tctc.count)
            FROM (
                SELECT count(distinct li.uraian)
                from laporan_informasi li
                         JOIN dds_wargas dds on li.form_id = dds.id
                WHERE form_type = 'App\Models\Dds_warga'
                  AND dds.user_id = ?
                  AND li.created_at BETWEEN ? AND ?
                UNION
                SELECT count(distinct li.uraian)
                from laporan_informasi li
                         JOIN deteksi_dinis dd on li.form_id = dd.id
                where form_type = 'App\Models\Deteksi_dini'
                  AND dd.user_id = ?
                  AND li.created_at BETWEEN ? AND ?
                UNION
                SELECT count(distinct ps.uraian_kejadian)
                FROM problem_solvings ps
                WHERE ps.user_id = ?
                  AND created_at BETWEEN ? AND ?
                UNION
                SELECT count(distinct pse.uraian_kejadian)
                FROM ps_eksekutifs pse
                WHERE pse.user_id = ?
                  AND created_at BETWEEN ? AND ?
                UNION
                SELECT count(distinct pns.uraian_masalah)
                FROM ps_non_sengketas pns
                WHERE pns.user_id = ?
                  AND created_at BETWEEN ? AND ?) as tctc;
        ", $params))->first()->sum;

        return [
            'user_id'           => $user->id,
            'minggu_ke'         => $date->weekOfYear,
            'tahun'             => $date->year,
            'personel_id'       => $user->personel->personel_id,
            'total_laporan'     => $sum,
            'klaster_rutinitas' => (bool)$sum ? ((int)$sum > 3 ? Constants::RUTINITAS_AKTIF : Constants::RUTINITAS_CUKUP) : Constants::RUTINITAS_KURANG,
            'bulan'             => $date->month,
        ];
    }
}
