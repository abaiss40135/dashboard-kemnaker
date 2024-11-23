<?php

namespace App\Services\Sislap\Lapbul\Pembinaan;

use App\Models\Sislap\Lapbul\Pembinaan\RealisasiAnggaran;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class RealisasiAnggaranService implements ExportInterface
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
        return RealisasiAnggaran::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('program_kegiatan', 'ilike', '%'.$search.'%')
                ->orWhere('bulan', 'ilike', '%'.$search.'%')
                ->orWhere('pagu_awal', $search)
                ->orWhere('pagu_revisi', $search)
                ->orWhere('realisasi_rupiah', $search)
                ->orWhere('sisa_rupiah', $search)
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
