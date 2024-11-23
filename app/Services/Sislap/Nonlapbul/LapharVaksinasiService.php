<?php

namespace App\Services\Sislap\Nonlapbul;

use App\Models\Sislap\Nonlapbul\LapharVaksinasi;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\ExportInterface;
use Illuminate\Http\Request;

class LapharVaksinasiService implements ExportInterface
{
    /**
     * @var SislapServiceInterface
     */
    private $sislapService;

    public function __construct(SislapServiceInterface $sislapService)
    {
        $this->sislapService = $sislapService;
    }

    public function search(Request $request)
    {
        $query = $this->getQuery($request);

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
    protected function getQuery($request)
    {
        $search = $request->search;
        $polda  = $request->polda;
        $start_date = $request->start_date;
        $end_date   = $request->end_date;
        return LapharVaksinasi::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2',
            'approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
            'approval.personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('kab_kota', 'ilike', '%'.$search.'%')
                ->orWhere('vaksinasi_sdm_kesehatan', 'ilike', '%'.$search.'%')
                ->orWhereHas('personel', function ($q) use ($search) {
                    $q->where('satuan1', 'ilike', '%'.$search . '%')
                      ->orWhere('satuan2', 'ilike', '%'.$search . '%');
                });
              });
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
