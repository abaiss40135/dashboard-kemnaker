<?php

namespace App\Services\Sislap\Lapsubjar\Sipolsus;

use App\Http\Traits\CustomPaginationTrait;
use App\Models\Polsus;
use Illuminate\Support\Str;

class DataDiklatDanKepemilikanKtaService
{
    use CustomPaginationTrait;

    private $jenjang_diklat;
    private $kepemilikan_kta;

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

    protected $mapInstansiPolsus = [
        1 => ['polsus_karantina_ikan', 'polsus_pwp3k'], //kkp
        2 => ['polhut_lhk'], //klhk
        3 => ['polsuspas'], //kemkuham
        4 => ['polsus_cagar_budaya'], //kemdikbudristek
        5 => ['polsus_barantan'], // pertanian
        6 => ['polsus_dishubdar'], // perhubungan
        7 => ['polhut_perhutani'], //perum perhutani
        8 => ['polsuska'], // kai
        9 => ['polsus_satpol_pp'] //dinas
    ];

    public function __construct($jenjang_diklat, $kepemilikan_kta = false)
    {
        $this->jenjang_diklat = $jenjang_diklat;
        $this->kepemilikan_kta = $kepemilikan_kta;
    }

    public function search($request)
    {
        $data = $this->getData($request);

        $result = $this->pagination($data, $request);
        return $result;
    }

    public function export($request)
    {
        $result = $this->getData($request);
        return $result;
    }

    public function sumExport($collection)
    {
        $sums       = [];

        foreach($collection as $data) {
            foreach($this->polices as $police) {
                foreach($this->attributes as $attr) {
                    if(array_key_exists("{$police}_{$attr}", $sums)) {
                        $sums["{$police}_{$attr}"] += $data[$police . "_" . $attr];
                    } else {
                        $sums = array_merge($sums, [
                            "{$police}_{$attr}" => $data[$police . "_" . $attr]
                        ]);
                    }
                }
            }
        }
        return $sums;
    }

    protected function getData($request)
    {
        $provinsi     = $request->provinsi;
        $kabupaten     = $request->kabupaten;
        $filterKl = $request->filter_kl;

        $queryData = $this->queryPolsus()
            ->when($this->jenjang_diklat != "all", function($query) {
                $query->where(function($query) {
                    $query->where('jenjang_diklat', $this->jenjang_diklat)
                        ->orWhere('jenjang_diklat', 'belum');
                });
            })
            ->when($provinsi, function ($query) use ($provinsi) {
                $query->where('provinsi', 'ilike', "%$provinsi%");
            })
            ->when($kabupaten, function ($query) use ($kabupaten) {
                $query->where('kabupaten', 'ilike' , "%$kabupaten%");
            })
            ->when($filterKl, function($query) use ($filterKl) {
                $query->whereHas('instansi', function($query) use ($filterKl) {
                    $query->where('id', $filterKl);
                });
            });

        // mendapatkan seluruh data polsus
        $collectionAllData = $queryData
//            ->select('id', 'instansi_id', 'created_at', 'jenis_polsus', 'provinsi', 'kabupaten', 'kepemilikan_kta', 'jenjang_diklat', 'user_id', 'kategori', 'status_pensiun')
            ->get();

        // mendapatkan seluruh provinsi dan kotakabupaten yang dimiliki polsus
        $collectionProvKab = $queryData
            ->select("provinsi", "kabupaten")
            ->groupBy('provinsi', "kabupaten")
            ->get();

        $result = [];

//        mapping data
        foreach($collectionProvKab as $data) {
            $data_polsus = [];
            if(!$filterKl) {
                foreach($this->polices as $police) {

                    $sdh = $this->checkJenjangDiklat($collectionAllData, $data->kabupaten, $police, "sudah");
                    $blm = $this->checkJenjangDiklat($collectionAllData, $data->kabupaten, $police, "belum");

                    $data_polsus = array_merge($data_polsus, [
                        $police . "_sdh" => $sdh,
                        $police . "_blm" => $blm,
                        $police . "_jml" => $sdh + $blm
                    ]);
                }
            } else {
                foreach($this->mapInstansiPolsus[$filterKl] as $police) {
                    $sdh = $this->checkJenjangDiklat($collectionAllData, $data->kabupaten, $police, "sudah");
                    $blm = $this->checkJenjangDiklat($collectionAllData, $data->kabupaten, $police, "belum");

                    $data_polsus = array_merge($data_polsus, [
                        $police . "_sdh" => $sdh,
                        $police . "_blm" => $blm,
                        $police . "_jml" => $sdh + $blm
                    ]);
                }
            }

            array_push($result, array_merge([
                    "provinsi" => $data->provinsi,
                    "kotakab" => $data->kabupaten,
                ], $data_polsus)
            );
        }

        return $result;
    }

    private function checkJenjangDiklat($collection, $kabupaten, $police, $status_diklat) {
        return $collection->where('jenis_polsus', $police)
            ->when(!empty($kabupaten), function($col) use ($kabupaten) {
                return $col->filter(function($item) use($kabupaten) {
                    return Str::contains(strtolower($item->kabupaten), strtolower($kabupaten));
                });
            })
            ->when($this->kepemilikan_kta, function ($col) use($status_diklat) {
                return $col->when($status_diklat == 'sudah', function($col) {
                    return $col->filter(function($item) {
                        return $item->kepemilikan_kta == 1;
                    });
                })->when($status_diklat == 'belum', function($col) {
                    return $col->filter(function($item) {
                        return $item->kepemilikan_kta != 1;
                    });
                });
            })
            ->when(!$this->kepemilikan_kta, function ($col) use($status_diklat) {
                return $col->when($status_diklat == 'sudah', function($col) {
                    return $col->filter(function($item) {
                        return $item->jenjang_diklat === $this->jenjang_diklat;
                    });
                })->when($status_diklat == 'belum', function($col) {
                    return $col->filter(function($item) {
                        return $item->jenjang_diklat === 'belum';
                    });
                });
            })
            ->count();
    }

    private function queryPolsus()
    {
        return Polsus::filterRolePolisiKhusus()->filterPolsusAktif()->filterByPolsusProvinceAndKabupaten();
    }
}
