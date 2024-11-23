<?php

namespace App\Services\Sislap\Lapsubjar\Binkamsa;

use App\Models\Sislap\Lapsubjar\Binkamsa\DataBujp;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class DataBujpService implements ExportInterface
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
        return DataBujp::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama_perusahaan', 'ilike', '%'.$search.'%')
                ->orWhere('konsultasi_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('konsultasi_tidak_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('penerapan_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('penerapan_tidak_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('pelatihan_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('pelatihan_tidak_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('penyediaan_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('penyediaan_tidak_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('jasa_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('jasa_tidak_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('kawal_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('kawal_tidak_aktif', 'ilike', '%'.$search.'%')
                ->orWhere('perluasan', $search)
                ->orWhere('total', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
