<?php

namespace App\Services\Sislap\Lapsubjar\Binanevpolsus;

use App\Models\Sislap\Lapsubjar\Binanevpolsus\DataKatpuanPolsus;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class DataKatpuanPolsusService implements ExportInterface
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
        return DataKatpuanPolsus::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('polda', 'ilike', '%'.$search.'%')
                ->orWhere('instansi', 'ilike', '%'.$search.'%')
                ->orWhere('tempat', 'ilike', '%'.$search.'%')
                ->orWhere('katpuan', 'ilike', '%'.$search.'%')
                ->orWhere('pria', 'ilike', '%'.$search.'%')
                ->orWhere('wanita', 'ilike', '%'.$search.'%')
                ->orWhere('jumlah', 'ilike', '%'.$search.'%')
                ->orWhere('tgl_buka', 'ilike', '%'.$search.'%')
                ->orWhere('tgl_tutup', 'ilike', '%'.$search.'%')
                ->orWhere('lama_hari', 'ilike', '%'.$search.'%')
                ->orWhere('keterangan', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
            });
        });
    }
}
