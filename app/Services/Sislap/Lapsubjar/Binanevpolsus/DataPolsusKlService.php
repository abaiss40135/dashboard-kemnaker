<?php

namespace App\Services\Sislap\Lapsubjar\Binanevpolsus;

use App\Models\Sislap\Lapsubjar\Binanevpolsus\DataPolsusKl;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class DataPolsusKlService implements ExportInterface
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
        return DataPolsusKl::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('kementerian', 'ilike', '%'.$search.'%')
                ->orWhere('nama', 'ilike', '%'.$search.'%')
                ->orWhere('pangkat', 'ilike', '%'.$search.'%')
                ->orWhere('nip', 'ilike', '%'.$search.'%')
                ->orWhere('golongan', 'ilike', '%'.$search.'%')
                ->orWhere('ttl', 'ilike', '%'.$search.'%')
                ->orWhere('jenis_kelamin', 'ilike', '%'.$search.'%')
                ->orWhere('agama', 'ilike', '%'.$search.'%')
                ->orWhere('jabatan', 'ilike', '%'.$search.'%')
                ->orWhere('wilayah_penugasan', 'ilike', '%'.$search.'%')
                ->orWhere('dik_umum', 'ilike', '%'.$search.'%')
                ->orWhere('tuk', $search)
                ->orWhere('bang', $search)
                ->orWhere('pim', $search)
                ->orWhere('keterangan', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
