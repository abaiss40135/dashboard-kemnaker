<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul\PascaGempaCianjur;

use App\Exports\Sislap\Nonlapbul\PascaGempaCianjur\RekapExport;
use App\Models\Sislap\Nonlapbul\PascaGempaCianjur\JenisGiatPascaGempa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

final class RekapLapharGempaCianjurController extends Controller
{
    public function index()
    {
        return view('administrator.sislap.nonlapbul.pasca-gempa-cianjur.rekap');
    }

    public function getData()
    {
        return response()->json($this->prepareData());
    }

    public function getExcel()
    {
        $excel = new RekapExport($this->prepareData()); 
        return $excel->download('rekap_laphar_pasca_gempa_cianjur.xlsx');
    }

    private function prepareData() 
    {
        $collection = $this->getCollection();
        $headers    = $this->getHeaders();
        $body       = [];

        foreach($headers as $h) foreach ($collection as $c) {
            if (empty($c->p) && empty($c->b)) continue;

            $satuan = $c->p ?? $c->b ?? '';
            if (!empty($satuan)) {
                if (empty($body[$satuan][$h])) $body[$satuan][$h] = 0;
                if ($c->nama == $h) $body[$satuan][$h] = $body[$satuan][$h] + $c->jumlah;
            }
        }

        return [
            'headers' => $headers,
            'body'    => $body
        ];
    }

    private function getHeaders()
    {
        return JenisGiatPascaGempa::pluck('nama')->toArray();
    }

    private function getCollection()
    {
        $request       = request();
        $polda         = $request->polda;
        $date_s        = $request->start_date;
        $date_e        = $request->end_date;
        $auth_user     = auth()->user();
        $auth_personel = $auth_user->personel;
        $auth_role     = $auth_user->role();
        $auth_level    = substr(strrchr($auth_role, '_'), 1);

        return DB::table('sislap_jenis_giat_pasca_gempa AS jk')
            ->select(
                'jk.nama',
                DB::raw('COUNT(sp) + COUNT(sb) AS jumlah'),
                ...(match($auth_level) {
                    'polda', 'polres' => [
                            DB::raw("split_part(pp.satuan2::TEXT, '-', 1) AS p"),
                            DB::raw("split_part(pb.satuan2::TEXT, '-', 1) AS b")
                        ],
                    default => [
                            DB::raw("split_part(pp.satuan1::TEXT, '-', 1) AS p"),
                            DB::raw("split_part(pb.satuan1::TEXT, '-', 1) AS b")
                        ]
                })
            )
            ->leftJoin('sislap_penanganan_pasca_gempa AS sp', 'sp.jenis_kegiatan_id', '=', 'jk.id')
            ->leftJoin('sislap_bantuan_pasca_gempa AS sb', 'sb.jenis_kegiatan_id', '=', 'jk.id')
            ->leftJoin('personel AS pp', 'pp.personel_id', '=', 'sp.personel_id')
            ->leftJoin('personel AS pb', 'pb.personel_id', '=', 'sb.personel_id')
            ->leftJoin('sislap_approval_laporan AS sap', function ($j) {
                $j->where('sap.approvable_type', 'App\Models\Sislap\Nonlapbul\PascaGempaCianjur\PenangananPascaGempa')
                  ->on('sap.approvable_id', '=', 'sp.id');
            })
            ->leftJoin('sislap_approval_laporan AS sab', function ($j) {
                $j->where('sab.approvable_type', 'App\Models\Sislap\Nonlapbul\PascaGempaCianjur\BantuanPascaGempa')
                  ->on('sab.approvable_id', '=', 'sb.id');
            })
            ->where(fn ($q) =>
                $q->when($auth_level != 'polda' && $auth_level != 'polres', fn ($q) =>
                    $q->where(fn ($q) =>
                        $q->where('sap.level', 'polda')
                          ->where(fn ($q) =>
                            $q->whereNull('sap.is_approve')
                              ->orWhere('sap.is_approve', true)
                          )
                    )
                    ->orWhere(fn ($q) =>
                        $q->where('sab.level', 'polda')
                          ->where(fn ($q) =>
                            $q->whereNull('sab.is_approve')
                              ->orWhere('sab.is_approve', true)
                          )
                    )
                )
                ->when($auth_level == 'polda', fn ($q) =>
                    $q->where(fn ($q) => 
                        $q->where('pp.satuan1', $auth_personel->satuan1)
                        ->orWhere('pb.satuan1', $auth_personel->satuan1)
                    )
                    ->where(fn ($q) =>
                        $q->where(fn ($q) =>
                            $q->where(fn ($q) =>
                                $q->where('sap.level', 'polres')
                                  ->orWhere('sap.level', 'polda')
                            )
                            ->where(fn ($q) =>
                                $q->whereNull('sap.is_approve')
                                  ->orWhere('sap.is_approve', true)
                            )
                        )
                        ->orWhere(fn ($q) =>
                            $q->where(fn ($q) =>
                                $q->where('sab.level', 'polres')
                                  ->orWhere('sab.level', 'polda')
                            )
                            ->where(fn ($q) =>
                                $q->whereNull('sab.is_approve')
                                  ->orWhere('sab.is_approve', true)
                            )
                        )
                    )
                )
                ->when($auth_level == 'polres', fn ($q) =>
                    $q->where('pp.satuan2', $auth_personel->satuan2)
                      ->orWhere('pb.satuan2', $auth_personel->satuan2)
                )
            )
            ->when($polda, fn ($q) =>
                $q->where('pp.satuan1', 'like', "$polda%")
                  ->orWhere('pb.satuan1', 'like', "$polda%")
            )
            ->when($date_s, fn ($q) =>
                $q->whereDate('sp.tanggal', '>=', $date_s)
                  ->orWhereDate('sb.tanggal', '>=', $date_s)
            )
            ->when($date_e, fn ($q) =>
                $q->whereDate('sp.tanggal', '<=', $date_e)
                  ->orWhereDate('sb.tanggal', '<=', $date_e)
            )
            ->groupBy('p', 'b', 'jk.nama')
            ->get();
    }
}
