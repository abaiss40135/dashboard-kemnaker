<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Http\Controllers\Controller;

class LapharDemoHariBuruhController extends Controller
{
    public function index()
    {
        session()->put('sislap_uri', request()->getRequestUri());
        return view('administrator.sislap.nonlapbul.laphar-demo-hari-buruh.index');
    }
}
