<?php

namespace App\Http\Controllers\Admin\PencarianMabes;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;

class CariBujpController extends Controller
{
    public function index(){
        $province = Provinsi::pluck('name' , 'code');
        return view('administrator.pencarian-mabes.cari-bujp' , compact('province'));
    }
}
