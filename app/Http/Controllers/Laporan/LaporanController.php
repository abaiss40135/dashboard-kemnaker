<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;

class LaporanController extends Controller
{

    public function index()
    {
        if (role('bhabinkamtibmas')){
            return view('bhabin.laporan.index');
        }
        if (role('satpam')){
            return view('templates.satpam.laporan.laporan');
        }
        if (role('polsus')){
            return view('templates.polsus.laporan.laporan');
        }
        return back();
    }

    public function menuDDS()
    {
        return view('bhabin.laporan.giat.dds.index');
    }
}
