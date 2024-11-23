<?php

namespace App\Services\Sislap\Sipolsus;

use App\Models\DataSenpi;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;

class DataSenpiAmunisiService implements ExportInterface
{
    private $sislapService;
    private $model;

    public $polices = [
        "polsuspas",
        "polhut_lhk",
        "polhut_perhutani",
        "polsus_cagar_budaya",
        "polsuska",
        "polsus_pwp3k",
        "polsus_karantina_ikan",
        "polsus_barantan",
        "polsus_satpol_pp",
        "polsus_dishubdar"
    ];

    public $attributes = [
        "genggam",
        "panjang",
        "jml"
    ];

    public function __construct($model)
    {
        $this->model = $model;
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
        $sums       = [];
        foreach ($this->polices as $police) {
            foreach ($this->attributes as $attribute){
                $sums[$police.'_'.$attribute] = $collection->sum($police.'_'.$attribute);
            }
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

        $tipe_datanya = DataSenpi::class ? "data_senpi" : "data_amunisi";

        return $this->model::query()
            ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
            ->when($withApproval, function ($query) {
                return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                    'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
            })
            ->when($search, function ($query) use ($search) {
                if (is_numeric($search)) {
                    return $query->where('polsuspas_genggam', $search)
                        ->orWhere('polsuspas_panjang'     , $search)
                        ->orWhere('polsuspas_jml'    , $search)
                        ->orWhere('polhut_lhk_genggam'       , $search)
                        ->orWhere('polhut_lhk_panjang'         , $search)
                        ->orWhere('polhut_lhk_jml'       , $search)
                        ->orWhere('polhut_perhutani_genggam'      , $search)
                        ->orWhere('polhut_perhutani_panjang'         , $search)
                        ->orWhere('polhut_perhutani_jml'    , $search)
                        ->orWhere('polsus_cagar_budaya_genggam'  , $search)
                        ->orWhere('polsus_cagar_budaya_panjang' , $search)
                        ->orWhere('polsus_cagar_budaya_jml'    , $search)
                        ->orWhere('polsuska_genggam'        , $search)
                        ->orWhere('polsuska_panjang'      , $search)
                        ->orWhere('polsuska_jml'     , $search)
                        ->orWhere('polsus_pwp3k_genggam'        , $search)
                        ->orWhere('polsus_pwp3k_panjang'        , $search)
                        ->orWhere('polsus_pwp3k_jml'        , $search)
                        ->orWhere('polsus_karantina_ikan_genggam'        , $search)
                        ->orWhere('polsus_karantina_ikan_panjang'        , $search)
                        ->orWhere('polsus_karantina_ikan_jml'        , $search)
                        ->orWhere('polsus_barantan_genggam'        , $search)
                        ->orWhere('polsus_barantan_panjang'        , $search)
                        ->orWhere('polsus_barantan_jml'        , $search)
                        ->orWhere('polsus_satpol_pp_genggam'        , $search)
                        ->orWhere('polsus_satpol_pp_panjang'        , $search)
                        ->orWhere('polsus_satpol_pp_jml'        , $search)
                        ->orWhere('polsus_dishubdar_genggam'        , $search)
                        ->orWhere('polsus_dishubdar_panjang'        , $search)
                        ->orWhere('polsus_dishubdar_jml'        , $search);
                }
                return $query->where('polres', 'ilike', "%$search%");
            })
            ->when($polda, function ($query) use ($polda, $tipe_datanya) {
                return $query->join('personel', 'personel.user_id', '=', $tipe_datanya . '.user_id')
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
