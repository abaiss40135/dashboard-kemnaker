<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas;

use App\Models\Sislap\Lapsubjar\Binpolmas\DataDai;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class DataDaiService implements ExportInterface
{
    private $sislapService;

    public function __construct(SislapServiceInterface $sislapService)
    {
        $this->sislapService = $sislapService;
    }

    public function search(array $request)
    {
        $query = $this->getQuery($request['search'] ?? "");

        return $this->sislapService->filterQueryByRole($query);
    }

    public function export(array $request)
    {
        $query = $this->getQuery($request['search'] ?? "");

        return $this->sislapService->filterQueryByRole($query, 0);
    }

    protected function getQuery($search)
    {
        return DataDai::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama_dai', 'ilike', '%'.$search.'%')
                ->orWhere('perorangan_kelompok', 'ilike', '%'.$search.'%')
                ->orWhere('no_hp', 'ilike', '%'.$search.'%')
                ->orWhere('rt_rw', 'ilike', '%'.$search.'%')
                ->orWhere('desa_kel', 'ilike', '%'.$search.'%')
                ->orWhere('kecamatan', 'ilike', '%'.$search.'%')
                ->orWhere('kab_kota', 'ilike', '%'.$search.'%')
                ->orWhere('keterangan', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
