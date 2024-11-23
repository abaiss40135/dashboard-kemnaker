<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Models\Sislap\Lapsubjar\Binpolmas\DataFkpm;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;
use App\Traits\ExportWithCountTrait;

class DataFkpmWilayahService implements ExportInterface
{
    private $sislapService;
    use ExportWithCountTrait;

    public $columns = [
        'nama_fkpm',
        'nama_petugas_polmas',
        'pangkat_petugas_polmas',
        'no_hp_petugas_polmas',
        'jumlah_anggota_fkpm',
        'wilayah',
        'bkpm',
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

        return DataFkpm::query()
            ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
            ->when($withApproval, function ($query) {
                return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                    'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
            })
            ->when($polda, function ($query) use ($polda) {
                return $query->join('personel', 'personel.user_id', '=', 'data_fkpms.user_id')
                    ->where('personel.satuan1', 'ilike', $polda.'-%');
            })
            ->where(fn($q) => (
                $q->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLDA),function($q){
                    return $q->where('polda', auth()->user()->personel->polda);
                })
                    ->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLRES),function($q){
                        return $q->where('polres', auth()->user()->personel->polres);
                    })
                    ->when($search, function ($query) use ($search) {
                        return $query->where('nama_fkpm', 'ilike', "%$search%")
                            ->orWhere('nama_petugas_polmas', 'ilike', "%$search%")
                            ->orWhere('no_hp_petugas_polmas', 'ilike', "%$search%")
                            ->orWhere('jumlah_anggota_fkpm', 'ilike', "%$search%")
                            ->orWhere('wilayah', 'ilike', "%$search%")
                            ->orWhere('bkpm', 'ilike', "%$search%")
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
            ))
            ->isWilayah();
    }
}
