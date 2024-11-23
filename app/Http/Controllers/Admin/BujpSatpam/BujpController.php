<?php

namespace App\Http\Controllers\Admin\BujpSatpam;

use App\Http\Controllers\Controller;
use App\Models\Bujp;

class BujpController extends Controller
{
    public function index(){

        $bujp = auth()->user()->bujp->load('nib:nib,kd_daerah');
        return view('bujp.index' , compact('bujp'));
    }
}
