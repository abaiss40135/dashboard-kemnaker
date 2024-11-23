<?php

namespace App\Http\Controllers\Admin\Pencarian;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;

class BujpAktifController extends Controller
{
    // tampilkan data provinsi ke view
    public function index(){
        $province = Provinsi::pluck('name' , 'id');
        return view('administrator.pencarian.bujp-aktif' , compact('province'));
    }
}
