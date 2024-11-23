<?php

namespace App\Services\Sislap\Lapsubjar\Bagrenmin;

use App\Models\Sislap\Lapsubjar\Bagrenmin\CapaianKinerja;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class CapaianKinerjaService implements ExportInterface
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
        return CapaianKinerja::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('satker', 'ilike', '%'. $search .'%')
                ->orWhere('sasaran', 'ilike', '%'.$search.'%')
                ->orWhere('indikator', 'ilike', '%'.$search.'%')
                ->orWhere('target', 'ilike', '%'.$search.'%')
                ->orWhere('realisasi', 'ilike', '%'.$search.'%')
                ->orWhere('kegiatan', 'ilike', '%'.$search.'%')
                ->orWhere('hasil', 'ilike', '%'.$search.'%')
                ->orWhere('hambatan', 'ilike', '%'.$search.'%')
                ->orWhere('solusi_hambatan', 'ilike', '%'.$search.'%')
                ->orWhere('keterangan', 'ilike', '%'.$search.'%')
                ->orWhere('triwulan', 'ilike', '%'.$search.'%')
                ->orWhere('tahun', $search)
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
              });
        });
    }
}
