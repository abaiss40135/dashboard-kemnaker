<?php

namespace App\Services\Sislap\Nonlapbul;

use App\Models\Sislap\Nonlapbul\PreemtifPmk;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;

class PreemtifPmkService implements ExportInterface
{
    private $sislapService;

    public $columns = [
        'sosialisasi',
        'pengobatan',
        'dekontaminasi',
        'amplifikasi_meme',
    ];

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

    public function sumExport($collection)
    {
        $sums = [];
        foreach ($this->columns as $column) {
            $sums[$column] = $collection->sum($column);
        }

        return $sums;
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

        return PreemtifPmk::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($withApproval, function ($query) {
            return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
        })
        ->when($search, function ($query) use ($search) {
            if (is_numeric($search)) {
                return $query->where('sosialisasi', $search)
                    ->orWhere('sosialisasi', $search)
                    ->orWhere('pengobatan', $search)
                    ->orWhere('dekontaminasi', $search)
                    ->orWhere('amplifikasi_meme', $search);
            }

            return $query->where('polres', 'ilike', "%$search%");
        })
        ->when($polda, function ($query) use ($polda) {
            return $query->join('personel', 'personel.user_id', '=', 'preemtif_pmks.user_id')
                         ->where('personel.satuan1', 'ilike', $polda.'-%');
        })
        ->when($start_date, function ($query) use ($start_date) {
            return $query->where('created_at', '>=', $start_date . ' 00:00:00');
        })
        ->when($end_date, function ($query) use ($end_date) {
            return $query->where('created_at', '<=', $end_date . ' 23:59:59');
        });
    }
}
