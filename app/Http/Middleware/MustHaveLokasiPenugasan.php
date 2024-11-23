<?php

namespace App\Http\Middleware;

use App\Http\Traits\SweetAlertTrait;
use App\Models\User;
use Closure;
use League\MimeTypeDetection\EmptyExtensionToMimeTypeMap;

class MustHaveLokasiPenugasan
{
    use SweetAlertTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (role('bhabinkamtibmas')) {
            $alert = [];
            if (auth()->user()->lokasiPenugasans()->count() == 0) {
                $alert['alert']     = 'notfound';
                $alert['message']   = 'Anda belum memasukan lokasi desa penugasan bhabinkantibmas, mohon tambah terlebih dahulu';
            } else if (User::where('id', auth()->user()->id)->whereHas('lokasiPenugasans', function ($query) {
                $query->where('jenis_lokasi', 'desa')->whereNull('village_code');
            })->count()) {
                $alert['alert']     = 'invalid';
                $alert['message']   = 'Desa lokasi penugasan tidak valid, silahkan edit lokasi penugasan anda terlebih dahulu';
            }
            if (isset($alert['message'])){
                request()->session()->flash('swal_lokasi_penugasan', [
                        'title'     => 'Perhatian',
                        'type'      => 'warning',
                    ] + $alert);
            }
        }
        return $next($request);
    }
}
