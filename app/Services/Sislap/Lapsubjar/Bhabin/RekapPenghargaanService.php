<?php

namespace App\Services\Sislap\Lapsubjar\Bhabin;

use App\Models\Sislap\Lapsubjar\Bhabin\RekapPenghargaan;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class RekapPenghargaanService implements ExportInterface
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
        return RekapPenghargaan::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('polres', 'ilike', '%'.$search.'%')
                ->orWhere('dds', 'ilike', '%'.$search.'%')
                ->orWhere('li', 'ilike', '%'.$search.'%')
                ->orWhere('sosial', 'ilike', '%'.$search.'%')
                ->orWhere('dana_perdata', 'ilike', '%'.$search.'%')
                ->orWhere('fisik', 'ilike', '%'.$search.'%')
                ->orWhere('non_fisik', 'ilike', '%'.$search.'%')
                ->orWhere('pendampingan_danadesa', 'ilike', '%'.$search.'%')
                ->orWhere('binluh_narkoba', 'ilike', '%'.$search.'%')
                ->orWhere('pengendalian_pemotonganruminansia', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
