<?php

namespace App\Http\Controllers\Admin\DashboardSuaraCapres2024;

use App\Exports\PemungutanSuaraCapres\PemungutanSuaraCapresExport;
use App\Http\Controllers\Controller;
use App\Services\DashboardSuaraCapres2024Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Excel;
use Yajra\DataTables\Facades\DataTables;

class DashboardPemungutanSuaraCapres2024Controller extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new DashboardSuaraCapres2024Service();
    }

    public function index()
    {
        if(!role('administrator')) {
            abort(403);
        }
        return view('administrator.dashboard-suara-capres2024.index');
    }

    public function akumulasiSuaraNasional(Request $request)
    {
        if(!role('administrator')) {
            abort(403);
        }
        $key = 'akumulasi_suara_capres2024_nasional';
        $ttl = now()->addMinutes(5);

        // cache data from call service
//        $data = Cache::remember($key, $ttl, function () use($request) {
//            return $this->service->akumulasiSuaraNasional($request);
//        });
        $data = $this->service->akumulasiSuaraNasional($request);

        return response()->json($data);
    }

    public function akumulasiSuaraPerProvinsi()
    {
        if(!role('administrator')) {
            abort(403);
        }
        $key = 'akumulasi_suara_capres2024_provinsi';
        $ttl = now()->addMinutes(5);

        // cache data from call service
        $data = Cache::remember($key, $ttl, function () {
            return $this->service->akumulasiSuaraPerProvinsi();
        });

        return response()->json($data);
    }

    public function akumulasiSuaraPerKabupaten($wilayah)
    {
        if(!role('administrator')) {
            abort(403);
        }
        $key = 'akumulasi_suara_capres2024_kota';
        $ttl = now()->addMinutes(5);

        // cache data from call service
        $data = $this->service->akumulasiSuaraPerKabupatenKota($wilayah);

        return response()->json($data);
    }

    public function akumulasiSuaraPerKecamatan($provinsi, $wilayah)
    {
        if(!role('administrator')) {
            abort(403);
        }
        $key = 'akumulasi_suara_capres2024_kecamatan';
        $ttl = now()->addMinutes(5);

        // cache data from call service
        $data = $this->service->akumulasiSuaraPerKecamatan($wilayah, $provinsi);

        return response()->json($data);
    }

    public function akumulasiSuaraPerKelurahan($provinsi, $kota, $wilayah)
    {
        if(!role('administrator')) {
            abort(403);
        }
        $key = 'akumulasi_suara_capres2024_kelurahan';
        $ttl = now()->addMinutes(5);

        // cache data from call service
        $wilayah = trim(str_replace('Kecamatan', '', $wilayah));
        $data = $this->service->akumulasiSuaraPerKelurahan($wilayah, $provinsi, $kota);

        return response()->json($data);
    }

    public function getDataTable(Request $request)
    {
        if(!role('administrator')) {
            abort(403);
        }
        return DataTables::eloquent($this->service->dataTable($request))->toJson();
    }

    public function exportNasional()
    {
        if(!role('administrator')) {
            abort(403);
        }

        return (new PemungutanSuaraCapresExport($this->service))->download('Akumulasi Suara Capres 2024.xlsx', Excel::XLSX);
    }
}
