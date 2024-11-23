<?php

namespace App\Providers;

use App\Services\AgamaService;
use App\Services\AkumulasiLaporanBhabinkamtibmasService;
use App\Services\AtensiPimpinanService;
use App\Services\BeritaService;
use App\Services\BUJPService;
use App\Services\ChecklistService;
use App\Services\DateService;
use App\Services\DDSTempatUsahaService;
use App\Services\DDSWargaService;
use App\Services\InfografisService;
use App\Services\Interfaces\AgamaServiceInterface;
use App\Services\Interfaces\AkumulasiLaporanBhabinkamtbmasServiceInterface;
use App\Services\Interfaces\AtensiPimpinanServiceInterface;
use App\Services\Interfaces\BUJPServiceInterface;
use App\Services\Interfaces\ChecklistServiceInterface;
use App\Services\Interfaces\DateServiceInterface;
use App\Services\Interfaces\DDSTempatUsahaServiceInterface;
use App\Services\Interfaces\InfografisServiceInterface;
use App\Services\Interfaces\KawasanServiceInterface;
use App\Services\Interfaces\KecamatanServiceInterface;
use App\Services\Interfaces\KlasterRutinitasServiceInterface;
use App\Services\Interfaces\KotaServiceInterface;
use App\Services\Interfaces\LaporanBhabinkamtibmasServiceInterface;
use App\Services\Interfaces\LaporanInformasiServiceInterface;
use App\Services\Interfaces\LaporanSatpamServiceInterface;
use App\Services\Interfaces\MemeServiceInterface;
use App\Services\Interfaces\NaskahServiceInterface;
use App\Services\Interfaces\NIBServiceInterface;
use App\Services\Interfaces\PaparanServiceInterface;
use App\Services\Interfaces\PencarianBUJPServiceInterface;
use App\Services\Interfaces\PencarianUmumServiceInterface;
use App\Services\Interfaces\PendapatWargaServiceInterface;
use App\Services\Interfaces\PersonelServiceInterface;
use App\Services\Interfaces\ProblemSolvingServiceInterface;
use App\Services\Interfaces\PSNonSengketaServiceInterface;
use App\Services\Interfaces\RegulasiServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\RiwayatSioServiceInterface;
use App\Services\Interfaces\SatpamServiceInterface;
use App\Services\Interfaces\Sislap\SislapServiceInterface;
use App\Services\Interfaces\StatusSioServiceInterface;
use App\Services\Interfaces\SukuServiceInterface;
use App\Services\Interfaces\TagServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\VideoLandingServiceInterface;
use App\Services\KawasanService;
use App\Services\KecamatanService;
use App\Services\KlasterRutinitasService;
use App\Services\KotaService;
use App\Services\LaporanBhabinkamtibmasService;
use App\Services\LaporanInformasiService;
use App\Services\LaporanSatpamService;
use App\Services\MemeService;
use App\Services\NaskahService;
use App\Services\NIBService;
use App\Services\PencarianBUJPService;
use App\Services\PaparanService;
use App\Services\PencarianUmumService;
use App\Services\PendapatWargaService;
use App\Services\PersonelService;
use App\Services\ProblemSolvingService;
use App\Services\PSNonSengketaService;
use App\Services\PSSengketaService;
use App\Services\DesaService;
use App\Services\DeteksiDiniService;
use App\Services\Interfaces\BeritaServiceInterface;
use App\Services\Interfaces\DDSWargaServiceInterface;
use App\Services\Interfaces\PSSengketaServiceInterface;
use App\Services\Interfaces\DesaServiceInterface;
use App\Services\Interfaces\DeteksiDiniServiceInterface;
use App\Services\Interfaces\KeywordServiceInterface;
use App\Services\Interfaces\LaporanPublikServiceInterface;
use App\Services\Interfaces\LokasiPenugasanServiceInterface;
use App\Services\Interfaces\ProvinsiServiceInterface;
use App\Services\Interfaces\SatuanServiceInterface;
use App\Services\Interfaces\Sislap\Nonlapbul\Laporan3t\LapharTracingServiceInterface;
use App\Services\KeywordService;
use App\Services\LaporanPublikService;
use App\Services\LokasiPenugasanService;
use App\Services\ProvinsiService;
use App\Services\RegulasiService;
use App\Services\RoleService;
use App\Services\RiwayatSioService;
use App\Services\SatpamService;
use App\Services\SatuanService;
use App\Services\Sislap\Nonlapbul\Laporan3t\LapharTracingService;
use App\Services\SislapService;
use App\Services\StatusSioService;
use App\Services\SukuService;
use App\Services\TagService;
use App\Services\UserService;
use App\Services\VideoLandingService;
use Illuminate\Support\ServiceProvider;

class ServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(BeritaServiceInterface::class, BeritaService::class);
        $this->app->bind(DDSWargaServiceInterface::class, DDSWargaService::class);
        $this->app->bind(PSSengketaServiceInterface::class, PSSengketaService::class);
        $this->app->bind(LokasiPenugasanServiceInterface::class, LokasiPenugasanService::class);
        $this->app->bind(KeywordServiceInterface::class, KeywordService::class);
        $this->app->bind(ProvinsiServiceInterface::class, ProvinsiService::class);
        $this->app->bind(KotaServiceInterface::class, KotaService::class);
        $this->app->bind(KecamatanServiceInterface::class, KecamatanService::class);
        $this->app->bind(DesaServiceInterface::class, DesaService::class);
        $this->app->bind(DeteksiDiniServiceInterface::class, DeteksiDiniService::class);
        $this->app->bind(AtensiPimpinanServiceInterface::class, AtensiPimpinanService::class);
        $this->app->bind(SukuServiceInterface::class, SukuService::class);
        $this->app->bind(AgamaServiceInterface::class, AgamaService::class);
        $this->app->bind(LaporanInformasiServiceInterface::class, LaporanInformasiService::class);
        $this->app->bind(ProblemSolvingServiceInterface::class, ProblemSolvingService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(NIBServiceInterface::class, NIBService::class);
        $this->app->bind(ChecklistServiceInterface::class, ChecklistService::class);
        $this->app->bind(RiwayatSioServiceInterface::class, RiwayatSioService::class);
        $this->app->bind(DateServiceInterface::class, DateService::class);
        $this->app->bind(PersonelServiceInterface::class, PersonelService::class);
        $this->app->bind(KlasterRutinitasServiceInterface::class, KlasterRutinitasService::class);
        $this->app->bind(AkumulasiLaporanBhabinkamtbmasServiceInterface::class, AkumulasiLaporanBhabinkamtibmasService::class);
        $this->app->bind(BUJPServiceInterface::class, BUJPService::class);
        $this->app->bind(PencarianBUJPServiceInterface::class, PencarianBUJPService::class);
        $this->app->bind(SatpamServiceInterface::class, SatpamService::class);
        $this->app->bind(TagServiceInterface::class, TagService::class);
        $this->app->bind(PaparanServiceInterface::class, PaparanService::class);
        $this->app->bind(VideoLandingServiceInterface::class, VideoLandingService::class);
        $this->app->bind(PencarianUmumServiceInterface::class, PencarianUmumService::class);
        $this->app->bind(RegulasiServiceInterface::class, RegulasiService::class);
        $this->app->bind(NaskahServiceInterface::class, NaskahService::class);
        $this->app->bind(InfografisServiceInterface::class, InfografisService::class);
        $this->app->bind(MemeServiceInterface::class, MemeService::class);
        $this->app->bind(StatusSioServiceInterface::class, StatusSioService::class);
        $this->app->bind(KawasanServiceInterface::class, KawasanService::class);
        $this->app->bind(DDSTempatUsahaServiceInterface::class, DDSTempatUsahaService::class);
        $this->app->bind(PendapatWargaServiceInterface::class, PendapatWargaService::class);
        $this->app->bind(SislapServiceInterface::class, SislapService::class);
        $this->app->bind(LapharTracingServiceInterface::class, LapharTracingService::class);
        $this->app->bind(LaporanPublikServiceInterface::class, LaporanPublikService::class);
        $this->app->bind(LaporanBhabinkamtibmasServiceInterface::class, LaporanBhabinkamtibmasService::class);
        $this->app->bind(LaporanSatpamServiceInterface::class, LaporanSatpamService::class);
        $this->app->bind(PSNonSengketaServiceInterface::class, PSNonSengketaService::class);
        $this->app->bind(SatuanServiceInterface::class, SatuanService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
