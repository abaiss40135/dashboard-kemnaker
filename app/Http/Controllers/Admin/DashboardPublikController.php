<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanPublik;
use Illuminate\Http\Request;

class DashboardPublikController extends Controller
{
    public function index()
    {
        return view('administrator.dashboard.publik');
    }

    public function chartJenisPengguna()
    {
        return LaporanPublik::query()
            ->has('laporan_informasi.keywords')
            ->has('pengguna_publik')
            ->get()->countBy('pengguna_publik.type')->all();
    }

    public function chartBidangInformasi()
    {
        return LaporanPublik::query()
            ->has('laporan_informasi.keywords')
            ->with('laporan_informasi')
            ->get()->countBy('laporan_informasi.bidang')->all();
    }
}
