<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas;

use App\Models\Sislap\Lapsubjar\Binpolmas\DataFkpm;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class DataFkpmService implements ExportInterface
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
        return DataFkpm::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama_fkpm', 'ilike', '%'.$search.'%')
                ->orWhere('nama_anggota_fkpm', 'ilike', '%'.$search.'%')
                ->orWhere('model_kawasan', 'ilike', '%'.$search.'%')
                ->orWhere('model_wilayah', 'ilike', '%'.$search.'%')
                ->orWhere('bkpm', 'ilike', '%'.$search.'%')
                ->orWhere('desa_kel', 'ilike', '%'.$search.'%')
                ->orWhere('kecamatan', 'ilike', '%'.$search.'%')
                ->orWhere('kab_kota', 'ilike', '%'.$search.'%')
                ->orWhere('provinsi', 'ilike', '%'.$search.'%')
                ->orWhere('keterangan', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
