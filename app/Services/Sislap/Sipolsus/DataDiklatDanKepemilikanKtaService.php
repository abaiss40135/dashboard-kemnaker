<?php

namespace App\Services\Sislap\Sipolsus;

use App\Models\Sislap\Lapsubjar\Sipolsus\DataDiklatKhusus;
use App\Models\Sislap\Lapsubjar\Sipolsus\DataDiklatReguler;
use App\Services\Interfaces\ExportInterface;
use App\Services\SislapService;

class DataDiklatDanKepemilikanKtaService implements ExportInterface
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
        "sdh",
        "blm",
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

//        $tipe_data_diklat = $this->model == DataDiklatReguler::class ? "data_diklat_reguler" : "data_diklat_khusus";
        $tipe_model = '';
        if($this->model == DataDiklatReguler::class)
        {
            $tipe_model .= "data_diklat_reguler";
        }
        elseif ($this->model == DataDiklatKhusus::class)
        {
            $tipe_model .= "data_diklat_khusus";
        }
        else
        {
            $tipe_model .= "data_kepemilikan_kta";
        }

        return $this->model::query()
            ->with('personel:user_id,personel_id,nama,satuan1,satuan2')
            ->when($withApproval, function ($query) {
                return $query->with('approvals.personel:user_id,personel_id,nama,satuan1,satuan2',
                    'approval.personel:user_id,personel_id,nama,satuan1,satuan2');
            })
            ->when($search, function ($query) use ($search) {
                if (is_numeric($search)) {
                    return $query->where('polsuspas_sdh', $search)
                        ->orWhere('polsuspas_blm'     , $search)
                        ->orWhere('polsuspas_jml'    , $search)
                        ->orWhere('polhut_lhk_sdh'       , $search)
                        ->orWhere('polhut_lhk_blm'         , $search)
                        ->orWhere('polhut_lhk_jml'       , $search)
                        ->orWhere('polhut_perhutani_sdh'      , $search)
                        ->orWhere('polhut_perhutani_blm'         , $search)
                        ->orWhere('polhut_perhutani_jml'    , $search)
                        ->orWhere('polsus_cagar_budaya_sdh'  , $search)
                        ->orWhere('polsus_cagar_budaya_blm' , $search)
                        ->orWhere('polsus_cagar_budaya_jml'    , $search)
                        ->orWhere('polsuska_sdh'        , $search)
                        ->orWhere('polsuska_blm'      , $search)
                        ->orWhere('polsuska_jml'     , $search)
                        ->orWhere('polsus_pwp3k_sdh'        , $search)
                        ->orWhere('polsus_pwp3k_blm'        , $search)
                        ->orWhere('polsus_pwp3k_jml'        , $search)
                        ->orWhere('polsus_karantina_ikan_sdh'        , $search)
                        ->orWhere('polsus_karantina_ikan_blm'        , $search)
                        ->orWhere('polsus_karantina_ikan_jml'        , $search)
                        ->orWhere('polsus_barantan_sdh'        , $search)
                        ->orWhere('polsus_barantan_blm'        , $search)
                        ->orWhere('polsus_barantan_jml'        , $search)
                        ->orWhere('polsus_satpol_pp_sdh'        , $search)
                        ->orWhere('polsus_satpol_pp_blm'        , $search)
                        ->orWhere('polsus_satpol_pp_jml'        , $search)
                        ->orWhere('polsus_dishubdar_sdh'        , $search)
                        ->orWhere('polsus_dishubdar_blm'        , $search)
                        ->orWhere('polsus_dishubdar_jml'        , $search);
                }
                return $query->where('polres', 'ilike', "%$search%");
            })
            ->when($polda, function ($query) use ($polda, $tipe_model) {
                return $query->join('personel', 'personel.user_id', '=', $tipe_model . '.user_id')
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
