<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas;

use App\Models\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmas;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;
use App\Traits\ExportWithCountTrait;

class KegiatanPetugasPolmasService implements ExportInterface
{
    use ExportWithCountTrait;

    private $sislapService;
    private $type;

    public function __construct($type = null)
    {
        $this->sislapService = new SislapService();
        $this->type = $type;
    }

    public function search($request)
    {
        $query = $this->getQuery($request, true);

        return $this->sislapService->filterQueryByRole($query);
    }

    public function export($request)
    {
        $query = $this->getQuery($request);

        return $this->sislapService->filterQueryByRole($query, 0);
    }

    /**
     * @param $search
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    protected function getQuery($request, $withApproval = null)
    {
        $search     = $request->search;
        $polda      = $request->polda;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        return KegiatanPetugasPolmas::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($withApproval, function ($query) {
            return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
        })
        ->when($polda, fn ($q) =>
            $q->join('personel', 'personel.user_id', '=', 'sislap_kegiatan_petugas_polmas.user_id')
                ->where('personel.satuan1', 'ilike', $polda.'-%')
        )
        ->where(fn($q) => (
            $q->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLDA), function ($q) {
                // filter polda by user
                return $q->where('polda', auth()->user()->personel->polda);
            })
                ->when(auth()->user()->haveRoleID(\App\Models\User::BINPOLMAS_POLRES), function ($q) {
                    // filter polda by user
                    return $q->where('polres', auth()->user()->personel->polres);
                })
                ->when(isset($search), fn ($q) =>
                    $q->where(fn ($q) =>
                        $q->when(is_numeric($search), fn ($q) =>
                            $q->where('sambang', $search)
                              ->orWhere('pemecahan_masalah', $search)
                              ->orWhere('laporan_informasi', $search)
                              ->orWhere('penanganan_perkara_ringan', $search)
                        )
                        ->when(is_string($search), fn ($q) =>
                            $q->where('polda', 'ilike', "%$search")
                              ->orWhere('polres', 'ilike', "%$search")
                        )
                    )
                )
                ->when($start_date, fn ($q) => $q->where('created_at', '>=', $start_date.' 00:00:00'))
                ->when($end_date, fn ($q) => $q->where('created_at', '<=', $end_date.' 23:59:59'))
                ->when($this->type, function($query) {
                    return $query->selectRaw("sum($this->type) as total")->select('kode_satuan');
                })
        ));
    }
}
