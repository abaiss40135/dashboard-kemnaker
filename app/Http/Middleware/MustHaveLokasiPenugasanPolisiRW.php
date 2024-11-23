<?php

namespace App\Http\Middleware;

use App\Models\PolisiRW\LokasiPenugasan;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class MustHaveLokasiPenugasanPolisiRW
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (LokasiPenugasan::where('user_id', $user->id)->count() == 0){
            return redirect()->route('lokasi-penugasan.polisi-rw.create');
        }
        return $next($request);
    }
}
