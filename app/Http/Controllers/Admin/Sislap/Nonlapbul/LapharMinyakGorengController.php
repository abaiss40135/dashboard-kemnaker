<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Http\Controllers\Controller;

class LapharMinyakGorengController extends Controller
{
    public function index()
    {
        session()->put('sislap_uri', request()->getRequestUri());
        return view('administrator.sislap.nonlapbul.laphar-minyak-goreng.index');
    }
}
