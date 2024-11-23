<?php

namespace App\Http\Controllers\OperatorKonten;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('administrator.index');
    }
}
