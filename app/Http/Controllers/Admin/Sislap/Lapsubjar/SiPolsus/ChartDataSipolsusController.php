<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\SiPolsus;

use App\Services\Sislap\Lapsubjar\Sipolsus\ChartDataSipolsusService;

class ChartDataSipolsusController
{
    private $service;

    public function __construct()
    {
        $this->service = new ChartDataSipolsusService();
    }

    public function tahap1()
    {
        $result = [
            'reguler' => $this->service->queryJenjangDiklat('reguler')->filterByAttributeUser()->filterByPolsusProvinceAndKabupaten()->count(),
            'khusus_pejabat_kl' => $this->service->queryJenjangDiklat('khusus_pejabat_kl')->filterByAttributeUser()->filterByPolsusProvinceAndKabupaten()->count(),
            'khusus_pensiun_tni_polri' => $this->service->queryJenjangDiklat('khusus_tni_polri')->filterByAttributeUser()->filterByPolsusProvinceAndKabupaten()->count(),
            'polsus_belum_diklat' => $this->service->queryJenjangDiklat('belum')->filterByAttributeUser()->filterByPolsusProvinceAndKabupaten()->count(),
            'polsus_memiliki_kta' => $this->service->queryKepemilikanKta()->filterByAttributeUser()->count(),
            'polsus_pensiun' => $this->service->queryPolsusPensiun()->filterByAttributeUser()->filterByPolsusProvinceAndKabupaten()->filterKategoriNotNullPolsus()->count()
        ];

        return response()->json($result);
    }

    public function tahap2($type)
    {
        $result = [
            'polsuspas' => $this->service->queryTahap2($type, 'polsuspas')->count(),
            'polhut_lhk' => $this->service->queryTahap2($type, 'polhut_lhk')->count(),
            'polhut_perhutani' => $this->service->queryTahap2($type, 'polhut_perhutani')->count(),
            'polsus_cagar_budaya' => $this->service->queryTahap2($type, 'polsus_cagar_budaya')->count(),
            'polsuska' => $this->service->queryTahap2($type, 'polsuska')->count(),
            'polsus_pwp3k' => $this->service->queryTahap2($type, 'polsus_pwp3k')->count(),
            'polsus_karantina_ikan' => $this->service->queryTahap2($type, 'polsus_karantina_ikan')->count(),
            'polsus_barantan' => $this->service->queryTahap2($type, 'polsus_barantan')->count(),
            'polsus_satpol_pp' => $this->service->queryTahap2($type, 'polsus_satpol_pp')->count(),
            'polsus_dishubdar' => $this->service->queryTahap2($type, 'polsus_dishubdar')->count()
        ];

        return response()->json($result);
    }

    public function tahap3($type, $jenis_polsus)
    {
        $underscoreJenisPolsus = $this->service->changeToSnakeCase($jenis_polsus);
        $query = $this->service->queryTahap2($type, $underscoreJenisPolsus);

        $collectionAllData = $query->get();
        $collectionProvinsiData = $query->select("provinsi")->groupBy('provinsi')->get();

        $result = [
            'provinsi' => $collectionProvinsiData->map(fn($q) => $q->provinsi)->toArray(),
            'data_polsus' => []
        ];

//        mapping data
        foreach($collectionProvinsiData as $col) {
            $total = $collectionAllData->where('provinsi', $col->provinsi)->count();
            $result['data_polsus'][$col->provinsi] = $total;
        }

        return $result;
    }
}
