<?php

namespace App\Http\Controllers\PolisiRW;

use App\Http\Controllers\Controller;
use App\Models\Infografis;
use App\Models\KategoriInformasi;
use App\Models\LandingPicture;
use App\Models\Link;
use App\Models\Meme;
use App\Models\Naskah;
use App\Models\Paparan;
use App\Models\Uu;
use App\Models\UuDalamPolri;
use App\Models\UuLuarPolri;
use App\Models\VideoLanding;
use App\Notifications\AtensiPimpinanNotification;
use App\Notifications\PusatInformasiNotification;
use Detection\MobileDetect;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $personel = auth()->user()->personel();
        $infografis = Infografis::latest()->take(8)->get();
        $paparan = Paparan::latest()->take(8)->get();
        $meme = Meme::latest()->take(8)->get();
        $peraturanDalam = UuDalamPolri::latest()->take(3)->get();
        $peraturanLuar = UuLuarPolri::latest()->take(3)->get();
        $undangUndang = Uu::latest()->take(3)->get();
        $naskah = Naskah::latest()->take(4)->get();
        $link = Link::latest()->get();
        $videoLanding = VideoLanding::latest()->take(5)->get();
        $gambar = LandingPicture::orderBy('id')->get('file')->toArray();
        $kategori = KategoriInformasi::orderBy('order')->where('active', true)->get();

        $detect = new MobileDetect();
        $notifications = auth()->user()->unreadNotifications;
        $pusatInformasiNotificationCount = $notifications->where('type', PusatInformasiNotification::class)->count();
        $atensiPimpinanNotificationCount = $notifications->where('type', AtensiPimpinanNotification::class)->count();

        return view(
            !$detect->isMobile() && !$detect->isTablet() ? 'polisi-rw.dekstop-index' : 'polisi-rw.mobile-index',
            compact(
                'infografis', 'paparan', 'meme', 'peraturanDalam',
                'peraturanLuar', 'undangUndang', 'naskah', 'link', 'videoLanding', 'personel',
                'gambar', 'kategori', 'pusatInformasiNotificationCount', 'atensiPimpinanNotificationCount'
            )
        );
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
