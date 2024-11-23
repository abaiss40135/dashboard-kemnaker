<?php

namespace App\Http\Controllers\Bujp\TransaksiBujp;

use App\Http\Controllers\Controller;
use App\Models\Bujp;
use Illuminate\Http\Request;

class PerluasanBujpController extends Controller
{
    public function index()
    {
        return view('bujp.transaksi-bujp.perluasan-bujp');
    }
}
