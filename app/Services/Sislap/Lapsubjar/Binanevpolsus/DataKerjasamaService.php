<?php

namespace App\Services\Sislap\Lapsubjar\Binanevpolsus;

use App\Models\Sislap\Lapsubjar\Binanevpolsus\DataKerjasama;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class DataKerjasamaService implements ExportInterface
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
        return DataKerjasama::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('kementerian_lembaga', 'ilike', '%'.$search.'%')
                ->orWhere('nota_kesepahaman', 'ilike', '%'.$search.'%')
                ->orWhere('perjanjian_kerjasama', 'ilike', '%'.$search.'%')
                ->orWhere('pedoman_kerja', 'ilike', '%'.$search.'%')
                ->orWhere('standar_operasional', 'ilike', '%'.$search.'%')
                ->orWhere('no_tgl', 'ilike', '%'.$search.'%')
                ->orWhere('masa_berlaku', 'ilike', '%'.$search.'%')
                ->orWhere('tentang_judul', 'ilike', '%'.$search.'%')
                ->orWhere('ruang_lingkup', 'ilike', '%'.$search.'%')
                ->orWhere('keterangan', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
