<?php

namespace App\Providers;

use App\Models\AtensiPimpinan;
use App\Models\Berita;
use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use App\Models\Infografis;
use App\Models\Jukrah;
use App\Models\Keyword;
use App\Models\LaporanInformasi;
use App\Models\Meme;
use App\Models\Naskah;
use App\Models\Paparan;
use App\Models\PendaftaranSio;
use App\Models\Personel;
use App\Models\Problem_solving;
use App\Models\PsEksekutif;
use App\Models\PsNonSengketa;
use App\Models\RiwayatSio;
use App\Models\Uu;
use App\Models\UuDalamPolri;
use App\Models\UuLuarPolri;
use App\Models\VideoLanding;
use App\Observers\AtensiPimpinanObserver;
use App\Observers\JukrahObserver;
use App\Observers\KeywordObserver;
use App\Observers\LaporanBhabinkamtibmasObserver;
use App\Observers\LaporanInformasiObserver;
use App\Observers\PendaftaranSioObserver;
use App\Observers\PersonelObserver;
use App\Observers\PusatInformasi\BeritaObserver;
use App\Observers\PusatInformasi\InfografisObserver;
use App\Observers\PusatInformasi\MemeObserver;
use App\Observers\PusatInformasi\NaskahObserver;
use App\Observers\PusatInformasi\PaparanObserver;
use App\Observers\PusatInformasi\UndangUndangInternalPolriObserver;
use App\Observers\PusatInformasi\UndangUndangObserver;
use App\Observers\PusatInformasi\VideoLandingObserver;
use App\Observers\RiwayatSioObserver;
use App\Observers\UndangUndangEksternalPolriObserver;
use Illuminate\Support\ServiceProvider;

class ObserverProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        self::registerLaporanBhabinkamtibmasObserver();
        Uu::observe(UndangUndangObserver::class);
        Meme::observe(MemeObserver::class);
        Naskah::observe(NaskahObserver::class);
        Jukrah::observe(JukrahObserver::class);
        Berita::observe(BeritaObserver::class);
        Paparan::observe(PaparanObserver::class);
        Keyword::observe(KeywordObserver::class);
        Personel::observe(PersonelObserver::class);
        RiwayatSio::observe(RiwayatSioObserver::class);
        Infografis::observe(InfografisObserver::class);
        UuLuarPolri::observe(UndangUndangEksternalPolriObserver::class);
        UuDalamPolri::observe(UndangUndangInternalPolriObserver::class);
        VideoLanding::observe(VideoLandingObserver::class);
        PendaftaranSio::observe(PendaftaranSioObserver::class);
        AtensiPimpinan::observe(AtensiPimpinanObserver::class);
        LaporanInformasi::observe(LaporanInformasiObserver::class);
    }

    private function registerLaporanBhabinkamtibmasObserver()
    {
        /** @var \Illuminate\Database\Eloquent\Model[] $MODELS */
        $models = [
            Dds_warga::class,
            Deteksi_dini::class,
            Problem_solving::class,
            PsNonSengketa::class,
            PsEksekutif::class
        ];

        foreach ($models as $model) {
            $model::observe(LaporanBhabinkamtibmasObserver::class);
        }
    }
}
