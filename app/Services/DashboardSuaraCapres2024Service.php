<?php

namespace App\Services;

use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Laporan\ProgramPemerintah\PemungutanSuaraCapres2024;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardSuaraCapres2024Service
{
    public function akumulasiSuaraNasional($request)
    {
        $query = PemungutanSuaraCapres2024::when($request->provinsi !== 'null', function($query) use($request) {
            return $query->where('provinsi_kode', $request->provinsi);
        })->when($request->kota !== 'null', function($query) use($request) {
            return $query->where('kabupaten_kode', $request->kota);
        })->when($request->kecamatan !== 'null', function($query) use($request) {
            return $query->where('kecamatan_kode', 'ilike', '%' . $request->kecamatan . '%');
        })->when($request->desa !== 'null', function($query) use($request) {
            return $query->where('kelurahan_kode', 'ilike', '%' . $request->desa . '%');
        });

        if($query->count() == 0) {
            return [
                'total_suara_01' => 0,
                'total_suara_02' => 0,
                'total_suara_03' => 0,
                'total_suara_tidak_sah' => 0,
                'total_semua_suara' => 0,
                'persentase_suara_01' => 0,
                'persentase_suara_02' => 0,
                'persentase_suara_03' => 0,
                'persentase_suara_tidak_sah' => 0
            ];
        }

        $totalSuara01 = $query->sum('suara_capres_1');
        $totalSuara02 = $query->sum('suara_capres_2');
        $totalSuara03 = $query->sum('suara_capres_3');
        $totalSuaraTidakSah = $query->sum('suara_tidak_sah');

        $totalSemuaSuara = $totalSuara01 + $totalSuara02 + $totalSuara03 + $totalSuaraTidakSah;

        $persentaseSuara01 = $totalSuara01 == 0 ? 0 : round(($totalSuara01 / $totalSemuaSuara) * 100, 5);
        $persentaseSuara02 = $totalSuara02 == 0 ? 0 : round(($totalSuara02 / $totalSemuaSuara) * 100, 5);
        $persentaseSuara03 = $totalSuara03 == 0 ? 0 : round(($totalSuara03 / $totalSemuaSuara) * 100, 5);
        $persentaseSuaraTidakSah = $totalSuaraTidakSah == 0 ? 0 : round(($totalSuaraTidakSah / $totalSemuaSuara) * 100, 5);

        // dibulatkan ke maksimal 5 angka dibelakang koma
        $persentaseSuara01 = str_replace('.', ',', $persentaseSuara01);
        $persentaseSuara02 = str_replace('.', ',', $persentaseSuara02);
        $persentaseSuara03 = str_replace('.', ',', $persentaseSuara03);
        $persentaseSuaraTidakSah = str_replace('.', ',', $persentaseSuaraTidakSah);

        return [
            'total_suara_01' => $totalSuara01,
            'total_suara_02' => $totalSuara02,
            'total_suara_03' => $totalSuara03,
            'total_suara_tidak_sah' => $totalSuaraTidakSah,
            'total_semua_suara' => $totalSemuaSuara,
            'persentase_suara_01' => $persentaseSuara01,
            'persentase_suara_02' => $persentaseSuara02,
            'persentase_suara_03' => $persentaseSuara03,
            'persentase_suara_tidak_sah' => $persentaseSuaraTidakSah
        ];
    }

    public function akumulasiSuaraPerProvinsi()
    {
        $querySuaraNasional = PemungutanSuaraCapres2024::select([
            DB::raw('SUM(suara_capres_1) AS total_suara_01'),
            DB::raw('SUM(suara_capres_2) AS total_suara_02'),
            DB::raw('SUM(suara_capres_3) AS total_suara_03'),
            DB::raw('SUM(suara_tidak_sah) AS total_suara_tidak_sah')
        ])->first();
        $totalSuaraNasional = $querySuaraNasional->total_suara_01 + $querySuaraNasional->total_suara_02 + $querySuaraNasional->total_suara_03 + $querySuaraNasional->total_suara_tidak_sah;

        $data = PemungutanSuaraCapres2024::selectRaw('
            provinsi_kode,
            SUM(suara_capres_1) AS total_suara_01,
            SUM(suara_capres_2) AS total_suara_02,
            SUM(suara_capres_3) AS total_suara_03,
            SUM(suara_tidak_sah) AS total_suara_tidak_sah
        ')
        ->groupBy('provinsi_kode')
        ->orderBy('provinsi_kode', 'asc')
        ->get()
        ->map(function($data) use($totalSuaraNasional) {
            $totalSemuaSuara = $data->total_suara_01 + $data->total_suara_02 + $data->total_suara_03 + $data->total_suara_tidak_sah;

            if($totalSemuaSuara == 0) {
                $data['persentase_suara_01'] = 0;
                $data['persentase_suara_02'] = 0;
                $data['persentase_suara_03'] = 0;
                $data['persentase_suara_tidak_sah'] = 0;
                $data['total_seluruh_suara'] = 0;
                $data['persentase_total_suara_provinsi'] = 0;
                return $data;
            }

            $presentaseSuara01 = $data->total_suara_01 == 0 ? 0 : round(($data->total_suara_01 / $totalSemuaSuara) * 100, 5);
            $presentaseSuara02 = $data->total_suara_02 == 0 ? 0 : round(($data->total_suara_02 / $totalSemuaSuara) * 100, 5);
            $presentaseSuara03 = $data->total_suara_03 == 0 ? 0 : round(($data->total_suara_03 / $totalSemuaSuara) * 100, 5);
            $presentaseSuaraTidakSah = $data->total_suara_tidak_sah == 0 ? 0 : round(($data->total_suara_tidak_sah / $totalSemuaSuara) * 100, 5);

            $data['persentase_suara_01'] = $presentaseSuara01;
            $data['persentase_suara_02'] = $presentaseSuara02;
            $data['persentase_suara_03'] = $presentaseSuara03;
            $data['persentase_suara_tidak_sah'] = $presentaseSuaraTidakSah;
            $data['total_seluruh_suara'] = $totalSemuaSuara;
            $data['persentase_total_suara_provinsi'] = str_replace('.', ',', round(($totalSemuaSuara / $totalSuaraNasional) * 100, 5));

            return $data;
        });

        return $data;
    }

    public function akumulasiSuaraPerKabupatenKota($wilayah)
    {
        $provinsiKode = Provinsi::where('name', 'ilike', $wilayah)->first()?->code;

        $querySuaraNasional = PemungutanSuaraCapres2024::where('provinsi_kode', $provinsiKode)->select([
            DB::raw('SUM(suara_capres_1) AS total_suara_01'),
            DB::raw('SUM(suara_capres_2) AS total_suara_02'),
            DB::raw('SUM(suara_capres_3) AS total_suara_03'),
            DB::raw('SUM(suara_tidak_sah) AS total_suara_tidak_sah')
        ])->first();
        $totalSuara = $querySuaraNasional->total_suara_01 + $querySuaraNasional->total_suara_02 + $querySuaraNasional->total_suara_03 + $querySuaraNasional->total_suara_tidak_sah;

        $data = PemungutanSuaraCapres2024::where('provinsi_kode', $provinsiKode)->selectRaw('
            kabupaten_kode,
            SUM(suara_capres_1) AS total_suara_01,
            SUM(suara_capres_2) AS total_suara_02,
            SUM(suara_capres_3) AS total_suara_03,
            SUM(suara_tidak_sah) AS total_suara_tidak_sah,
            SUM(suara_capres_1 + suara_capres_2 + suara_capres_3 + suara_tidak_sah) AS total_seluruh_suara
        ')
            ->groupBy('kabupaten_kode')
            ->orderBy('total_seluruh_suara', 'desc')
            ->orderBy('kabupaten_kode', 'asc')
            ->get()
            ->map(function($data) use($totalSuara) {
                return $this->perhitunganSuara($data, $totalSuara, 'kabupaten');
            })
            ->sortByDesc('total_seluruh_suara');

        return $data;
    }

    public function akumulasiSuaraPerKecamatan($wilayah, $provinsi)
    {
        $provinsiKode = Provinsi::where('name', 'ilike', $provinsi)->first()?->code;
        $kotaKode = Kota::where([
            ['name', 'ilike', $wilayah],
            ['province_code', $provinsiKode]
        ])->first()?->code;

        $querySuaraNasional = PemungutanSuaraCapres2024::where('kabupaten_kode', $kotaKode)->select([
            DB::raw('SUM(suara_capres_1) AS total_suara_01'),
            DB::raw('SUM(suara_capres_2) AS total_suara_02'),
            DB::raw('SUM(suara_capres_3) AS total_suara_03'),
            DB::raw('SUM(suara_tidak_sah) AS total_suara_tidak_sah')
        ])->first();
        $totalSuara = $querySuaraNasional->total_suara_01 + $querySuaraNasional->total_suara_02 + $querySuaraNasional->total_suara_03 + $querySuaraNasional->total_suara_tidak_sah;

        $data = PemungutanSuaraCapres2024::where('kabupaten_kode', $kotaKode)->selectRaw('
            kecamatan_kode,
            SUM(suara_capres_1) AS total_suara_01,
            SUM(suara_capres_2) AS total_suara_02,
            SUM(suara_capres_3) AS total_suara_03,
            SUM(suara_tidak_sah) AS total_suara_tidak_sah,
            SUM(suara_capres_1 + suara_capres_2 + suara_capres_3 + suara_tidak_sah) AS total_seluruh_suara
        ')
            ->groupBy('kecamatan_kode')
            ->orderBy('kecamatan_kode', 'asc')
            ->orderBy('total_seluruh_suara', 'desc')
            ->get()
            ->map(function($data) use($totalSuara) {
                return $this->perhitunganSuara($data, $totalSuara, 'kecamatan');
            })
            ->sortByDesc('total_seluruh_suara');

        return $data;
    }

    public function akumulasiSuaraPerKelurahan($wilayah, $provinsi, $kota)
    {
        $provinsiKode = Provinsi::where('name', 'ilike', $provinsi)->first()->code;
        $kotaKode = Kota::where([
            ['name', 'ilike', $kota],
            ['province_code', $provinsiKode]
        ])->first()?->code;
        $kecamatanKode = Kecamatan::where([
            ['name', 'ilike', '%' . $wilayah . '%'],
            ['city_code', $kotaKode]
        ])->first()?->code;

        $querySuaraNasional = PemungutanSuaraCapres2024::where('kecamatan_kode', $kecamatanKode)->select([
            DB::raw('SUM(suara_capres_1) AS total_suara_01'),
            DB::raw('SUM(suara_capres_2) AS total_suara_02'),
            DB::raw('SUM(suara_capres_3) AS total_suara_03'),
            DB::raw('SUM(suara_tidak_sah) AS total_suara_tidak_sah')
        ])->first();
        $totalSuara = $querySuaraNasional->total_suara_01 + $querySuaraNasional->total_suara_02 + $querySuaraNasional->total_suara_03 + $querySuaraNasional->total_suara_tidak_sah;

        $data = PemungutanSuaraCapres2024::where('kecamatan_kode', $kecamatanKode)->selectRaw('
            kelurahan_kode,
            SUM(suara_capres_1) AS total_suara_01,
            SUM(suara_capres_2) AS total_suara_02,
            SUM(suara_capres_3) AS total_suara_03,
            SUM(suara_tidak_sah) AS total_suara_tidak_sah,
            SUM(suara_capres_1 + suara_capres_2 + suara_capres_3 + suara_tidak_sah) AS total_seluruh_suara
        ')
            ->groupBy('kelurahan_kode')
            ->orderBy('kelurahan_kode', 'asc')
            ->orderBy('total_seluruh_suara', 'desc')
            ->get()
            ->map(function($data) use($totalSuara) {
                return $this->perhitunganSuara($data, $totalSuara, 'kelurahan');
            })
            ->sortbyDesc('total_seluruh_suara');

        return $data;
    }

    public function dataTable(Request $request)
    {
        return PemungutanSuaraCapres2024::when($request->provinsi, function($query) use($request) {
            return $query->where('provinsi_kode', $request->provinsi);
        })->when($request->kabupaten, function($query) use($request) {
            return $query->where('kabupaten_kode', $request->kabupaten);
        })->when($request->kecamatan, function($query) use($request) {
            return $query->where('kecamatan_kode', 'ilike', '%' . $request->kecamatan . '%');
        })->when($request->kelurahan, function($query) use($request) {
            return $query->where('kelurahan_kode', 'ilike', '%' . $request->kelurahan . '%');
        })
            ->orderBy('kecamatan_kode', 'asc')
            ->orderBy('created_at', 'desc');
    }

    private function perhitunganSuara($data, $totalSuara, $type = 'provinsi')
    {
        $totalSuaraPerBaris = $data->total_suara_01 + $data->total_suara_02 + $data->total_suara_03 + $data->total_suara_tidak_sah;

        if($totalSuaraPerBaris == 0) {
            $data['persentase_suara_01'] = 0;
            $data['persentase_suara_02'] = 0;
            $data['persentase_suara_03'] = 0;
            $data['persentase_suara_tidak_sah'] = 0;
            $data['total_seluruh_suara'] = 0;
            $data['persentase_total_suara_' . $type] = 0;
            return $data;
        }

        $presentaseSuara01 = $data->total_suara_01 == 0 ? 0 : round(($data->total_suara_01 / $totalSuaraPerBaris) * 100, 5);
        $presentaseSuara02 = $data->total_suara_02 == 0 ? 0 : round(($data->total_suara_02 / $totalSuaraPerBaris) * 100, 5);
        $presentaseSuara03 = $data->total_suara_03 == 0 ? 0 : round(($data->total_suara_03 / $totalSuaraPerBaris) * 100, 5);
        $presentaseSuaraTidakSah = $data->total_suara_tidak_sah == 0 ? 0 : round(($data->total_suara_tidak_sah / $totalSuaraPerBaris) * 100, 5);

        $data['persentase_suara_01'] = $presentaseSuara01;
        $data['persentase_suara_02'] = $presentaseSuara02;
        $data['persentase_suara_03'] = $presentaseSuara03;
        $data['persentase_suara_tidak_sah'] = $presentaseSuaraTidakSah;
        $data['persentase_total_suara_' . $type] = str_replace('.', ',', round(($totalSuaraPerBaris / $totalSuara) * 100, 5));

        if(array_key_exists('total_seluruh_suara', $data->toArray())) {
            $data['total_seluruh_suara'] = $totalSuaraPerBaris;
        }

        return $data;
    }
}
