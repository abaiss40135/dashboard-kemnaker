<?php

namespace App\Services\Sislap\Nonlapbul;

use App\Models\Sislap\Nonlapbul\LapharPelatihanFaba;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;

class LapharPelatihanFabaService implements ExportInterface
{
    /**
     * @var SislapServiceInterface
     */
    private $sislapService;

    public function __construct(SislapServiceInterface $sislapService)
    {
        $this->sislapService = $sislapService;
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
        $search = $request->search;
        $search     = $request->search;
        $polda      = $request->polda;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;

        return LapharPelatihanFaba::query()
            ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
            ->when($withApproval, function ($query) {
                return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                    'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('polda', 'ilike', '%'. $search .'%');
            })
            ->when($polda, function ($query) use ($polda) {
                return $query->join('personel', 'personel.user_id', '=', 'laphar_pmks.user_id')
                            ->where('personel.satuan1', 'ilike', $polda.'-%');
            })
            ->when($start_date, function ($query) use ($start_date) {
                return $query->where('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                return $query->where('created_at', '<=', $end_date);
            });
    }
}
