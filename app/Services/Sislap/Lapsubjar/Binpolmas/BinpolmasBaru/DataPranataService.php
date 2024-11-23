<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Models\Sislap\Lapsubjar\Binpolmas\DataPranata;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;
use App\Traits\ExportWithCountTrait;

class DataPranataService implements ExportInterface
{
    private $sislapService;
    use ExportWithCountTrait;

    public $columns = [
        'nama_pranata',
        'nama_ketua_adat',
        'no_hp_ketua_adat',
        'nama_petugas_polmas',
        'pangkat_petugas_polmas',
        'no_hp_petugas_polmas',
        'balai_adat',
        'jumlah_anggota_pranata',
        'rt',
        'rw',
        'dusun',
        'desa_kel',
        'kecamatan',
        'kab_kota',
        'provinsi',
        'keterangan',
    ];

    public function __construct()
    {
        $this->sislapService = new SislapService();
    }

    public function search($request)
    {
        $query = $this->getQuery($request, true);

        return $this->sislapService->filterQueryByRole($query);
    }

    public function export($request)
    {
        $query = $this->getQuery($request);

        return $this->sislapService->filterQueryByRole($query, 0);
    }

    public function sumExport($collection)
    {
        $sums = [];
        foreach ($this->columns as $column) {
            $sums[$column] = $collection->sum($column);
        }

        return $sums;
    }

    /**
     * @param $search
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    protected function getQuery($request, $withApproval = null)
    {
        $search     = $request->search;
        $polda      = $request->polda;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        return DataPranata::query()
            ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
            ->when($withApproval, function ($query) {
                return $query->with(
                    'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                    'approval.personel:user_id,personel_id,nama,satuan1,satuan2'
                );
            })
            ->when($polda, function ($query) use ($polda) {
                return $query->join('personel', 'personel.user_id', '=', 'data_pranatas.user_id')
                    ->where('personel.satuan1', 'ilike', $polda . '-%');
            })
            ->where(fn($q) => (
                $q->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLDA), function ($q) {
                    // filter polda by user
                    return $q->where('polda', auth()->user()->personel->polda);
                })
                    ->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLRES), function ($q) {
                        // filter polda by user
                        return $q->where('polres', auth()->user()->personel->polres);
                    })
                    ->when($search, function ($query) use ($search) {
                        return $query->where('nama_pranata', 'ilike', "%$search%")
                            ->orWhere('nama_ketua_adat', 'ilike', "%$search%")
                            ->orWhere('no_hp_ketua_adat', 'ilike', "%$search%")
                            ->orWhere('nama_petugas_polmas', 'ilike', "%$search%")
                            ->orWhere('pangkat_petugas_polmas', 'ilike', "%$search%")
                            ->orWhere('no_hp_petugas_polmas', 'ilike', "%$search%")
                            ->orWhere('balai_adat', 'ilike', "%$search%")
                            ->orWhere('jumlah_anggota_pranata', 'ilike', "%$search%")
                            ->orWhere('rt', 'ilike', "%$search%")
                            ->orWhere('rw', 'ilike', "%$search%")
                            ->orWhere('dusun', 'ilike', "%$search%")
                            ->orWhere('desa_kel', 'ilike', "%$search%")
                            ->orWhere('kecamatan', 'ilike', "%$search%")
                            ->orWhere('kab_kota', 'ilike', "%$search%")
                            ->orWhere('provinsi', 'ilike', "%$search%")
                            ->orWhere('keterangan', 'ilike', "%$search%")
                            ->orWhere('polda', 'ilike', "%$search%")
                            ->orWhere('polres', 'ilike', "%$search%");
                    })
                    ->when($start_date, function ($query) use ($start_date) {
                        return $query->where('created_at', '>=', $start_date . ' 00:00:00');
                    })
                    ->when($end_date, function ($query) use ($end_date) {
                        return $query->where('created_at', '<=', $end_date . ' 23:59:59');
                    })
            ));
    }
}
