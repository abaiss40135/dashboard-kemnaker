<?php

namespace App\Http\Controllers\Bhabin;

use App\Http\Controllers\Controller;
use App\Models\Infografis;
use App\Models\Link;
use App\Models\Meme;
use App\Models\Naskah;
use App\Models\Paparan;
use App\Models\Uu;
use App\Models\UuDalamPolri;
use App\Models\UuLuarPolri;
use App\Models\VideoLanding;
use Detection\MobileDetect;
use Illuminate\Http\Request;

class PusatInformasiController extends Controller
{
    protected $detect;

    public function __construct()
    {
        $this->detect = new MobileDetect();
    }

    public function index()
    {
        $link = Link::all();

        return !$this->detect->isMobile() && !$this->detect->isTablet()
            ? view('bhabin.tampilan-baru.pusat-informasi.index', ['link' => $link])
            : view('bhabin.pusat-informasi.index', ['link' => $link]);
    }

    public function showUU(Request $request)
    {
        $itemPaginate = !$this->detect->isMobile() && !$this->detect->isTablet() ? 3 : 4;
        $uu = Uu::where('nama_uu', 'ilike', '%'.$request->uu.'%')
            ->orWhere('deskripsi_uu', 'ilike', '%'.$request->uu.'%')
            ->latest()->paginate($itemPaginate, ['*'], 'page');

        return response()->json($uu);
    }

    public function showPDPolri(Request $request)
    {
        $peraturanDalam = UuDalamPolri::where('nama_uu', 'ilike', '%'.$request->pd_polri.'%')
                                      ->orWhere('deskripsi_uu', 'ilike', '%'.$request->pd_polri.'%')
                                      ->latest()->paginate(4, ['*'], 'page');

        return response()->json($peraturanDalam);
    }

    public function showPLPolri(Request $request)
    {
        $peraturanLuar = UuLuarPolri::where('nama_uu', 'ilike', '%'.$request->pl_polri.'%')
                                    ->orWhere('deskripsi_uu', 'ilike', '%'.$request->pl_polri.'%')
                                    ->latest()->paginate(4, ['*'], 'page');

        return response()->json($peraturanLuar);
    }

    public function showMeme(Request $request)
    {
        $meme = Meme::where('nama_meme', 'ilike', '%'.$request->meme.'%')
                    ->orWhere('caption', 'ilike', '%'.$request->meme.'%')
                    ->latest()->paginate(4, ['*'], 'page');

        return response()->json($meme);
    }

    public function showInfografis(Request $request)
    {
        $itemPaginate = !$this->detect->isMobile() && !$this->detect->isTablet() ? 1 : 4;
        $infografis = Infografis::where('judul', 'ilike', '%'.$request->infografis.'%')
            ->orWhere('deskripsi', 'ilike', '%'.$request->infografis.'%')
            ->latest()->paginate($itemPaginate, ['*'], 'page');

        return response()->json($infografis);
    }

    public function showPaparan(Request $request)
    {
        $itemPaginate = !$this->detect->isMobile() && !$this->detect->isTablet() ? 1 : 4;
        $paparan = Paparan::where('nama_paparan', 'ilike', '%'.$request->paparan.'%')
                          ->latest()->paginate($itemPaginate, ['*'], 'page');

        return response()->json($paparan);
    }

    public function showVideo(Request $request)
    {
        $videos = VideoLanding::where('judul_video', 'ilike', '%'.$request->video.'%')
                              ->latest()->paginate(3, ['*'], 'page');

        return response()->json($videos);
    }

    public function video()
    {
        return view('bhabin.video.index');
    }

    public function showNaskah(Request $request)
    {
        $naskah = Naskah::where('nama_naskah', 'ilike', '%'.$request->naskah.'%')
                        ->orWhere('deskripsi_naskah', 'ilike', '%'.$request->naskah.'%')
                        ->latest()->paginate(4, ['*'], 'page');

        return response()->json($naskah);
    }
}
