<?php

namespace App\Services\Sislap\Lapsubjar\Sipolsus;

use App\Http\Traits\CustomPaginationTrait;
use App\Models\Polsus;

class DataPensiunPolsusService
{
    use CustomPaginationTrait;

    private $jenisPolsus;

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

        foreach($collection as $polsus)
        {
            // jika variabel sums kosong, maka inisiate isinya.
            if(count($sums) == 0)
            {
                $sums['polsus_aktif'] = $polsus['polsus_aktif'];
                $sums['polsus_pensiun'] = $polsus['polsus_pensiun'];
            } else {
                $sums['polsus_aktif'] = $sums['polsus_aktif'] + $polsus['polsus_aktif'];
                $sums['polsus_pensiun'] = $sums['polsus_pensiun'] + $polsus['polsus_pensiun'];
            }
        }

        $sums['jml'] = $sums['polsus_aktif'] + $sums['polsus_pensiun'];
        return $sums;
    }

    public function dataPolsusPensiun($kabupaten)
    {
        $query = Polsus::filterPolsusPensiun()->filterByJenisPolsus($this->jenisPolsus)
            ->where('kabupaten', 'ilike', '%' . $kabupaten . '%')->get();

        return $query->toArray();
    }

    private function getData($request)
    {
        $result = [];

        $queryData = $this->queryWilayah($request);
        $arrJenisPolsus = ['polsuspas', 'polsuska', 'polhut_lhk', 'polhut_perhutani'];

        foreach($queryData as $data) {
            // jika jenis polsusnya mempunyai kategori, maka attr kategori pada arr data harus ada isinya.
            if(in_array($this->jenisPolsus, $arrJenisPolsus) && $data['kategori'] ||
                !in_array($this->jenisPolsus, $arrJenisPolsus))
            {
                $polsusPensiun = $this->queryPolsus($data)
                    ->filterPolsusPensiun()
                    ->count();

                $polsusAktif = $this->queryPolsus($data)->filterPolsusAktif()->count();

                array_push($result, [
                    'provinsi' => $data->provinsi,
                    'kabupaten' => $data->kabupaten,
                    'kategori' => $data->kategori,
                    'polsus_aktif' => $polsusAktif,
                    'polsus_pensiun' => $polsusPensiun,
                    'jml' => $polsusAktif + $polsusPensiun
                ]);
            }
        }
        return $result;
    }

    private function queryWilayah($request) {
        $search = $request->search;
        $provinsi = $request->provinsi;
        $kabupaten = $request->kabupaten;

        $klProvinsi = auth()->user()->haveRoleID(26);
        $klKabupaten = auth()->user()->haveRoleID(27);

        return Polsus::filterByJenisPolsus($this->jenisPolsus)
                    ->filterRolePolisiKhusus()
                    ->when($klProvinsi, function($query) {
                        $query->where('provinsi', 'ilike', '%' . auth()->user()->polsus->provinsi . '%');
                    })
                    ->when($klKabupaten, function($query) {
                        $query->where('provinsi', 'ilike', '%' . auth()->user()->polsus->kabupaten . '%');
                    })
                    ->when($provinsi, function($query) use ($provinsi) {
                        $query->where('provinsi', 'ilike', '%'. $provinsi .'%');
                    })
                    ->when($kabupaten, function($query) use ($kabupaten) {
                        $query->where('kabupaten', 'ilike', '%'. $kabupaten .'%');
                    })
                    ->when($search, function($query) use ($search) {
                        $query->where('kategori', 'ilike', '%'. $search .'%');
                    })
                    ->orderBy('provinsi', 'asc')
                    ->orderBy('kabupaten', 'asc')
                    ->orderBy('kategori', 'asc')
                    ->select('provinsi', 'kabupaten', 'kategori')
                    ->groupBy('provinsi', 'kabupaten', 'kategori')
                    ->get();
    }

    private function queryPolsus($data)
    {
        return Polsus::filterRolePolisiKhusus()->filterByJenisPolsus($this->jenisPolsus)
            ->where([
                ['provinsi', 'ilike', '%' . $data->provinsi . '%'],
                ['kabupaten', 'ilike', '%' . $data->kabupaten . '%']
            ])
            ->when($data->kategori, function($query) use ($data) {
                $query->where('kategori', $data->kategori);
            });
    }
}
