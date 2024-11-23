<?php

namespace App\Services\Sislap\Sipolsus\Korwasbintek;

use App\Models\Sislap\Lapsubjar\Sipolsus\Korwasbintek\Koordinasi;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;

class KoordinasiService implements ExportInterface
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

        return Koordinasi::query()
        ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
        ->when($withApproval, function ($query) {
            return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
        })
        ->when($search, function ($query) use ($search) {
                return $query->where('polda', 'ilike', "%$search%")
                    ->orWhere('polres',       'ilike', "%$search%")    
                    ->orWhere('bentuk_kegiatan', 'ilike', "%$search%")
                    ->orWhere('jml_kegiatan', 'ilike', "%$search%")
                    ->orWhere('jml_pers_yang_terlibat', 'ilike', "%$search%")
                    ->orWhere('hasil',        'ilike', "%$search%")
                    ->orWhere('kendala',      'ilike', "%$search%")
                    ->orWhere('solusi',       'ilike', "%$search%");
        })
        ->when($polda, function ($query) use ($polda) {
            return $query->join('personel', 'personel.user_id', '=', 'kegiatan_korwasbintek_koordinasis.user_id')
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
