<?php

namespace App\Http\Controllers\Bhabin;

use App\Http\Controllers\Controller;
use App\Models\LokasiPenugasan;
use Detection\MobileDetect;
use Illuminate\Http\Request;

class HaloBhabinController extends Controller
{
    public function index()
    {
        $detect = new MobileDetect();

        return !$detect->isMobile() && !$detect->isTablet()
            ? view('bhabin.tampilan-baru.halo-bhabin.index')
            : view('bhabin.halo-bhabin.index');
    }

    public function search(Request $request)
    {
        $query = LokasiPenugasan::leftJoin('users', 'users.id', '=', 'lokasi_penugasans.user_id')
            ->leftJoin('personel', 'personel.user_id', '=', 'lokasi_penugasans.user_id')
            ->whereNotNull('personel.nama');

        if ($request->has('provinsi') && !empty($request->provinsi)) {
            $query->where('lokasi_penugasans.province_code', $request->provinsi);
        }
        if ($request->has('kabupaten') && !empty($request->kabupaten)) {
            $query->where('lokasi_penugasans.city_code', $request->kabupaten);
        }
        if ($request->has('kecamatan') && !empty($request->kecamatan)) {
            $query->where('lokasi_penugasans.district_code', $request->kecamatan);
        }

        return response()->json($query->orderByDesc('users.last_login_at')->paginate(6));
    }
}
