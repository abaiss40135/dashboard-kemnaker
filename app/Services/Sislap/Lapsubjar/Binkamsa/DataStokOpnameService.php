<?php

namespace App\Services\Sislap\Lapsubjar\Binkamsa;

use App\Models\Sislap\Lapsubjar\Binkamsa\DataStokOpname;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class DataStokOpnameService implements ExportInterface
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
        return DataStokOpname::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('bulan', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
