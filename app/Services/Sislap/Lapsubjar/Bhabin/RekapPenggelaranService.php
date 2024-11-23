<?php

namespace App\Services\Sislap\Lapsubjar\Bhabin;

use App\Models\Sislap\Lapsubjar\Bhabin\RekapPenggelaran;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class RekapPenggelaranService implements ExportInterface
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
        return RekapPenggelaran::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('tgl_input_data', 'ilike', '%'.$search.'%')
                ->orWhere('polres', 'ilike', '%'.$search.'%')
                ->orWhere('jumlah_desa', 'ilike', '%'.$search.'%')
                ->orWhere('jumlah_kelurahan', 'ilike', '%'.$search.'%')
                ->orWhere('jumlah_bhabin', 'ilike', '%'.$search.'%')
                ->orWhere('bina1_desa', 'ilike', '%'.$search.'%')
                ->orWhere('bina2_desa', 'ilike', '%'.$search.'%')
                ->orWhere('bina3_desa', 'ilike', '%'.$search.'%')
                ->orWhere('bina4_desa', 'ilike', '%'.$search.'%')
                ->orWhere('desa_kel_binaan', 'ilike', '%'.$search.'%')
                ->orWhere('desa_kel_sentuhan', 'ilike', '%'.$search.'%')
                ->orWhere('desa_kel_pantauan', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
