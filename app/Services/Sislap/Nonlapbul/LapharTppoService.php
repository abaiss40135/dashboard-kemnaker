<?php

namespace App\Services\Sislap\Nonlapbul;

use App\Models\Sislap\Nonlapbul\LapharTppo;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;

class LapharTppoService implements ExportInterface
{
    private $sislapService;

    public function __construct()
    {
        $this->sislapService = new SislapService();
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

        return LapharTppo::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($withApproval, function ($query) {
            return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
        })
        ->when($search, fn ($q) =>
            $q->where('polda', 'ilike', "%$search%")
            ->orwhere('polres', 'like', "%$search%")
            ->orwhere(fn ($q) =>
                $q->when(is_numeric($search), fn ($q) =>
                    $q->where('tatap_muka', $search)
                    ->orWhere('media_cetak', $search)
                    ->orWhere('media_sosial', $search)
                    ->orWhere('binluh', $search)
                    ->orWhere('koordinasi_p3mi', $search)
                    ->orWhere('koordinasi_dinas', $search)
                    ->orWhere('workshop', $search)
                )
            )
        )
        ->when($polda, fn ($q) =>
            $q->join('personel', 'personel.user_id', '=', 'laphar_Tppo.user_id')
              ->where('personel.satuan1', 'like', "$polda-%")
        )
        ->when($start_date, fn ($q) => $q->where('created_at', '>=', "$start_date 00:00:00"))
        ->when($end_date, fn ($q) => $q->where('created_at', '<=', "$end_date 23:59:59"));
    }
}
