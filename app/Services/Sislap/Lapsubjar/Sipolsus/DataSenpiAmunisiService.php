<?php

namespace App\Services\Sislap\Lapsubjar\Sipolsus;

use App\Http\Traits\CustomPaginationTrait;
use App\Models\Sislap\Lapsubjar\Sipolsus\DataSenpi;
use App\Models\Sislap\Lapsubjar\Sipolsus\DataAmunisi;
use App\Services\Interfaces\ExportInterface;

class DataSenpiAmunisiService implements ExportInterface
{
    use CustomPaginationTrait;

    private $jenisPolsus;
    private $kategori;

    private $id_data_senpi_amunisi_collection = [];

    public $attributes = [
        "genggam",
        "panjang",
        "jml"
    ];

    public function __construct($jenisPolsus)
    {
        $this->jenisPolsus = $jenisPolsus;
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
        $sums = [];

        if(count($collection)) {
            foreach($collection as $data) {
                if(count($sums) == 0) {
                    $sums = array_merge($sums, [
                        'genggam' => $data['senpi']['genggam'] + $data['amunisi']['genggam'],
                        'panjang' => $data['senpi']['panjang'] + $data['amunisi']['panjang'],
                    ]);
                } else {
                    $sums['genggam'] = $sums['genggam'] + $data['senpi']['genggam'] + $data['amunisi']['genggam'];
                    $sums['panjang'] = $sums['panjang'] + $data['senpi']['panjang'] + $data['amunisi']['panjang'];
                }
            }

            $sums['jml'] = $sums['genggam'] + $sums['panjang'];
        }
        return $sums;
    }

    private function getData($request) {
        $result = [];

        $query = $this->getQuery(DataSenpi::class, $request);
        foreach ($query as $data) {
            $data_senpi = [];
            $data_amunisi = [];

            // senpi
            $genggam_senpi = $this->countData($data->provinsi, $data->kabupaten, $data->kategori, 'genggam', 'senpi');
            $panjang_senpi = $this->countData($data->provinsi, $data->kabupaten, $data->kategori, 'panjang', 'senpi');
            $data_senpi = array_merge($data_senpi, [
                "genggam" => $genggam_senpi,
                "panjang" => $panjang_senpi,
                "jml" => $genggam_senpi + $panjang_senpi,
                "id_data" => $this->id_data_senpi_amunisi_collection
            ]);


            // amunisi
            $genggam_amunisi = $this->countData($data->provinsi, $data->kabupaten, $data->kategori, 'genggam', 'amunisi');
            $panjang_amunisi = $this->countData($data->provinsi, $data->kabupaten, $data->kategori, 'panjang', 'amunisi');
            $data_amunisi = array_merge($data_amunisi, [
                "genggam" => $genggam_amunisi,
                "panjang" => $panjang_amunisi,
                "jml" => $genggam_amunisi + $panjang_amunisi,
                "id_data" => $this->id_data_senpi_amunisi_collection
            ]);

            array_push($result, [
                'kategori' => $data->kategori,
                'provinsi' => $data->provinsi,
                'kabupaten' => $data->kabupaten,
                'senpi' => $data_senpi,
                'amunisi' => $data_amunisi,
            ]);
        };

        return $result;
    }

    public function getQuery($model, $request) {
        $search = $request->search;
        $provinsi = $request->provinsi;
        $kabupaten = $request->kabupaten;

        $operatorKlProvinsi = auth()->user()->haveRoleID(26);
        $operatorKlKotaKab = auth()->user()->haveRoleID(27);

        return $model::where('jenis_polsus', $this->jenisPolsus)
//            ->when($operatorKlProvinsi, function($query) {
//                $query->where('provinsi', 'ilike', auth()->user()->polsus->provinsi);
//            })
//            ->when($operatorKlKotaKab, function($query) {
//                $query->where('kabupaten', 'ilike', auth()->user()->polsus->kabupaten);
//            })
            ->when($provinsi, function ($query) use ($provinsi) {
                $query->where('provinsi', 'ilike' , '%'. $provinsi .'%');
            })
            ->when($kabupaten, function ($query) use ($kabupaten) {
                $query->where('kabupaten', 'ilike' , '%'. $kabupaten .'%');
            })
            ->when($search, function ($query) use ($search) {
                $query->where('kategori', 'ilike' , '%'. $search .'%');
            })
            ->orderBy('provinsi', 'asc')
            ->orderBy('kabupaten', 'asc')
            ->orderBy('kategori', 'asc')
            ->select("provinsi", "kabupaten", 'kategori')
            ->groupBy('provinsi', "kabupaten", 'kategori')
            ->get();
    }

    private function countData($provinsi, $kabupaten, $kategori, $type, $typeModel) {
        $model = $typeModel == 'senpi' ? DataSenpi::class : DataAmunisi::class;
        $result = 0;
        $type = $typeModel . "_" . $type;

        $collection = $model::where('jenis_polsus', $this->jenisPolsus)
            ->where('kabupaten', $kabupaten)
            ->where('provinsi', $provinsi)
            ->when($kategori, function($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->select($type, 'id')
            ->get();

        $id_collection = $collection->pluck('id');
        $this->id_data_senpi_amunisi_collection = $id_collection;

        foreach($collection as $data) {
            $result += $data->{$type};
        }

        return $result;
    }
}
