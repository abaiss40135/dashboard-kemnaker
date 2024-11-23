<?php

namespace App\Services\Sislap\Lapsubjar\Komsatpam;

use App\Models\Sislap\Lapsubjar\Komsatpam\DataAssesor;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class DataAssesorService implements ExportInterface
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
        return DataAssesor::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama', 'ilike', '%'.$search.'%')
                ->orWhere('polri', 'ilike', '%'.$search.'%')
                ->orWhere('non_polri', 'ilike', '%'.$search.'%')
                ->orWhere('no_reg_assesor', 'ilike', '%'.$search.'%')
                ->orWhere('gu', 'ilike', '%'.$search.'%')
                ->orWhere('gm', 'ilike', '%'.$search.'%')
                ->orWhere('gp', 'ilike', '%'.$search.'%')
                ->orWhere('jml', 'ilike', '%'.$search.'%')
                ->orWhere('status', 'ilike', '%'.$search.'%')
                ->orWhere('keterangan', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
              });
        });
    }
}
