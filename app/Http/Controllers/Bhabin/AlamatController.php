<?php

namespace App\Http\Controllers\Bhabin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function provinsi() {
        $provinces = Provinsi::pluck('name', 'code');

        return response()->json($provinces);
    }

    public function kota(Request $request){
        $cities = Kota::where('province_code', $request->get('id'))
            ->pluck('name', 'code');

        return response()->json($cities);
    }

    // ambil data kecamatan
    public function kecamatan(Request $request){
        $districts = Kecamatan::where('city_code', $request->get('id'))
            ->pluck('name', 'code');

        return response()->json($districts);
    }

    // ambil data desa
    public function desa(Request $request){
        $villages = Desa::where('district_code', $request->get('id'))
            ->pluck('name', 'code');

        return response()->json($villages);
    }


}
