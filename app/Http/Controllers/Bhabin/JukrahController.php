<?php

namespace App\Http\Controllers\Bhabin;

use App\Http\Controllers\Controller;
use App\Models\Jukrah;
use Detection\MobileDetect;
use Illuminate\Http\Request;

class JukrahController extends Controller
{
    public function index()
    {
        $detect = new MobileDetect();

        return !$detect->isMobile() && !$detect->isTablet()
            ? view('bhabin.tampilan-baru.jukrah.index')
            : view('bhabin.jukrah.index');
    }

    public function search(Request $request)
    {
        $jukrah = Jukrah::where('nama', 'ilike', '%'.$request->search.'%')
                    ->latest()->paginate(6, ['*'], 'page');

        return response()->json($jukrah);
    }
}
