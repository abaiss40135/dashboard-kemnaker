<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas;

use App\Models\Sislap\Lapsubjar\Binpolmas\DataKommas;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class DataKommasService implements ExportInterface
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
        return DataKommas::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama_kommas', 'ilike', '%'.$search.'%')
                ->orWhere('badan_hukum', 'ilike', '%'.$search.'%')
                ->orWhere('akta_notaris', 'ilike', '%'.$search.'%')
                ->orWhere('pengesahan', 'ilike', '%'.$search.'%')
                ->orWhere('npwp', 'ilike', '%'.$search.'%')
                ->orWhere('duk_pembina', 'ilike', '%'.$search.'%')
                ->orWhere('pengurus', 'ilike', '%'.$search.'%')
                ->orWhere('jenis_komunitas', 'ilike', '%'.$search.'%')
                ->orWhere('kebijakan_komunitas', 'ilike', '%'.$search.'%')
                ->orWhere('jumlah_anggota', 'ilike', '%'.$search.'%')
                ->orWhere('keterangan', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
