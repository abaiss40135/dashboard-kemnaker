<?php

namespace App\Http\Controllers\Bhabin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
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
use App\Services\Interfaces\PencarianUmumServiceInterface;
use Detection\MobileDetect;

class LandingController extends Controller
{
    public function __construct()
    {
        if (!roles(['bhabinkamtibmas', 'satpam', 'administrator'])) {
            return redirect()->route('dashboard.bhabin');
        }
        if (can('dashboard_access')) {
            return redirect()->back();
        }
    }

    public function index()
    {
        $personel = [];
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

        if (role('polsus')) {
            $polsus = auth()->user()->polsus;
            $personel['nama'] = $polsus ? $polsus->nama : '-';
            $personel['posisi'] = $polsus ? $polsus->pangkat : '-';
            $personel['lokasi'] = $polsus ? $polsus->detail_alamat : '-';
            $personel['nomor'] = $polsus ? $polsus->no_hp : '-';
            $personel['instansi'] = $polsus ? $polsus->instansi->instansi : '-';
            $personel['foto'] = $polsus ? $polsus->foto_profile : '-';
        } elseif (role('satpam')) {
            $satpam = auth()->user()->satpam;
            $personel['nama'] = $satpam ? $satpam->nama : '-';
            $personel['posisi'] = 'Satpam';
            $personel['lokasi'] = $satpam ? $satpam->lokasi : '-';
            $personel['foto'] = $satpam ? $satpam->foto_profile : '-';
            $personel['nomor'] = $satpam ? $satpam->no_kta : '-';
            $personel['instansi'] = $satpam->bujp->nama_badan_usaha ?? '-';
            $personel['tanggal_lahir'] = $satpam ? $satpam->tanggal_lahir : '-';
            $personel['no_hp'] = $satpam ? $satpam->no_hp : '-';

            // If no report more than 2 weeks, suspend account
            // $isExpired = auth()->user()->satpam()
            //     ->whereDoesntHave('laporanKejadian', function ($query) {
            //         $query->whereDate('created_at', '>', now()->subWeeks(2));
            //     })
            //     ->whereDoesntHave('laporanInformasis', function ($query) {
            //         $query->whereDate('created_at', '>', now()->subWeeks(2));
            //     })
            //     ->exists();
            // if ($isExpired) {
            //     $this->flashError('Akun anda kami tangguhkan (Korbinmas Baharkam Polri)');
            //     auth()->logout();
            //     return redirect()->route('login');
            // }
        } elseif (role('bhabinkamtibmas')) {
            $personel = session('personel');
            $personel['posisi'] = 'Bhabinkamtibmas';
            $personel['lokasi'] = ($personel['jabatan'] ?? '').(!empty($personel['keterangan_tambahan']) ? ' ('.$personel['keterangan_tambahan'].')' : '');
            $personel['nomor'] = $personel['nrp'] ?? '';
            $personel['instansi'] = $personel['pangkat'] ?? '';
            $personel['no_hp'] = $personel['handphone'] ?? '';
        } elseif (role('publik')) {
            $pengguna = auth()->user()->pengguna_publik;
            $personel['nama'] = $pengguna->nama;
            $personel['posisi'] = 'Pengguna Publik';
            $personel['lokasi'] = $pengguna->alamat;
            $personel['nomor'] = $pengguna->pekerjaan;
            $personel['instansi'] = $pengguna->lokasi_bekerja;
        } elseif (role('bhabinkamtibmas_pensiun')) {
            $this->flashError('Maaf, Anda terdeteksi sudah memasuki masa pensiun');
            auth()->logout();

            return redirect()->route('login');
        } elseif (role('bhabinkamtibmas_mutasi')) {
            $this->flashError('Maaf, Anda terdeteksi sudah dimutasikan');
            auth()->logout();

            return redirect()->route('login');
        }
        $detect = new MobileDetect();
        $notifications = auth()->user()->unreadNotifications;
        $pusatInformasiNotificationCount = $notifications->where('type', PusatInformasiNotification::class)->count();
        $atensiPimpinanNotificationCount = $notifications->where('type', AtensiPimpinanNotification::class)->count();

        return view(
            !$detect->isMobile() && !$detect->isTablet() ? 'bhabin.tampilan-baru.index' : 'bhabin.home',
            compact(
                'infografis',
                'paparan',
                'meme',
                'peraturanDalam',
                'peraturanLuar',
                'undangUndang',
                'naskah',
                'link',
                'videoLanding',
                'personel',
                'gambar',
                'kategori',
                'pusatInformasiNotificationCount',
                'atensiPimpinanNotificationCount'
            )
        );
    }

    public function showBerita($id)
    {
        $data = Berita::where('id', $id)->first();

        return view('bhabin.berita.berita', compact('data'));
    }

    public function search()
    {
        return view('pencarian-umum.index');
    }

    public function kategori(KategoriInformasi $kategoriInformasi, PencarianUmumServiceInterface $pencarianUmumService)
    {
        return view('bhabin.kategori', compact('kategoriInformasi'));
    }
}
