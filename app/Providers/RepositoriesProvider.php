<?php

namespace App\Providers;

use App\Repositories\Abstracts\AgamaRepositoryAbstract;
use App\Repositories\Abstracts\AkumulasiLaporanBhabinkamtibmasRepositoryAbstract;
use App\Repositories\Abstracts\AnggotaKeluargaRepositoryAbstract;
use App\Repositories\Abstracts\AtensiPimpinanRepositoryAbstract;
use App\Repositories\Abstracts\BeritaRepositoryAbstract;
use App\Repositories\Abstracts\BerkasPendaftaranSioRepositoryAbstract;
use App\Repositories\Abstracts\BUJPRepositoryAbstract;
use App\Repositories\Abstracts\ChecklistRepositoryAbstract;
use App\Repositories\Abstracts\DDSWargaRepositoryAbstract;
use App\Repositories\Abstracts\KawasanRepositoryAbstract;
use App\Repositories\Abstracts\KecamatanRepositoryAbstract;
use App\Repositories\Abstracts\KlasterRutinitasRepositoryAbstract;
use App\Repositories\Abstracts\KotaRepositoryAbstract;
use App\Repositories\Abstracts\LaporanBhabinkamtibmasRepositoryAbstract;
use App\Repositories\Abstracts\LaporanInformasiRepositoryAbstract;
use App\Repositories\Abstracts\LaporanSatpamRepositoryAbstract;
use App\Repositories\Abstracts\NIBRepositoryAbstract;
use App\Repositories\Abstracts\PaparanRepositoryAbstract;
use App\Repositories\Abstracts\PendapatWargaRepositoryAbstract;
use App\Repositories\Abstracts\PersonelRepositoryAbstract;
use App\Repositories\Abstracts\ProblemSolvingRepositoryAbstract;
use App\Repositories\Abstracts\PSNonSengketaRepositoryAbstract;
use App\Repositories\Abstracts\PSSengketaRepositoryAbstract;
use App\Repositories\Abstracts\DesaRepositoryAbstract;
use App\Repositories\Abstracts\DeteksiDiniRepositoryAbstract;
use App\Repositories\Abstracts\KeywordRepositoryAbstract;
use App\Repositories\Abstracts\LaporanPublikRepositoryAbstract;
use App\Repositories\Abstracts\LokasiPenugasanRepositoryAbstract;
use App\Repositories\Abstracts\ProvinsiRepositoryAbstract;
use App\Repositories\Abstracts\RoleRepositoryAbstract;
use App\Repositories\Abstracts\RiwayatSioRepositoryAbstract;
use App\Repositories\Abstracts\SatpamRepositoryAbstract;
use App\Repositories\Abstracts\SatuanRepositoryAbstract;
use App\Repositories\Abstracts\StatusSioRepositoryAbstract;
use App\Repositories\Abstracts\SukuRepositoryAbstract;
use App\Repositories\Abstracts\TagRepositoryAbstract;
use App\Repositories\Abstracts\UserRepositoryAbstract;
use App\Repositories\AgamaRepository;
use App\Repositories\AkumulasiLaporanBhabinkamtibmasRepository;
use App\Repositories\AnggotaKeluargaRepository;
use App\Repositories\AtensiPimpinanRepository;
use App\Repositories\BeritaRepository;
use App\Repositories\BerkasPendaftaranSioRepository;
use App\Repositories\BUJPRepository;
use App\Repositories\ChecklistRepository;
use App\Repositories\DDSWargaRepository;
use App\Repositories\KawasanRepository;
use App\Repositories\KecamatanRepository;
use App\Repositories\KlasterRutinitasRepository;
use App\Repositories\KotaRepository;
use App\Repositories\LaporanBhabinkamtibmasRepository;
use App\Repositories\LaporanInformasiRepository;
use App\Repositories\LaporanSatpamRepository;
use App\Repositories\NIBRepository;
use App\Repositories\PaparanRepository;
use App\Repositories\PendapatWargaRepository;
use App\Repositories\PersonelRepository;
use App\Repositories\ProblemSolvingRepository;
use App\Repositories\PSNonSengketaRepository;
use App\Repositories\PSSengketaRepository;
use App\Repositories\DesaRepository;
use App\Repositories\DeteksiDiniRepository;
use App\Repositories\KeywordRepository;
use App\Repositories\LaporanPublikRepository;
use App\Repositories\LokasiPenugasanRepository;
use App\Repositories\ProvinsiRepository;
use App\Repositories\RoleRepository;
use App\Repositories\RiwayatSioRepository;
use App\Repositories\SatpamRepository;
use App\Repositories\SatuanRepository;
use App\Repositories\StatusSioRepository;
use App\Repositories\SukuRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(BeritaRepositoryAbstract::class, BeritaRepository::class);
        $this->app->bind(DDSWargaRepositoryAbstract::class, DDSWargaRepository::class);
        $this->app->bind(PSSengketaRepositoryAbstract::class, PSSengketaRepository::class);
        $this->app->bind(LokasiPenugasanRepositoryAbstract::class, LokasiPenugasanRepository::class);
        $this->app->bind(ProvinsiRepositoryAbstract::class, ProvinsiRepository::class);
        $this->app->bind(KotaRepositoryAbstract::class, KotaRepository::class);
        $this->app->bind(KecamatanRepositoryAbstract::class, KecamatanRepository::class);
        $this->app->bind(DesaRepositoryAbstract::class, DesaRepository::class);
        $this->app->bind(KeywordRepositoryAbstract::class, KeywordRepository::class);
        $this->app->bind(DeteksiDiniRepositoryAbstract::class, DeteksiDiniRepository::class);
        $this->app->bind(AtensiPimpinanRepositoryAbstract::class, AtensiPimpinanRepository::class);
        $this->app->bind(AgamaRepositoryAbstract::class, AgamaRepository::class);
        $this->app->bind(SukuRepositoryAbstract::class, SukuRepository::class);
        $this->app->bind(AnggotaKeluargaRepositoryAbstract::class, AnggotaKeluargaRepository::class);
        $this->app->bind(PendapatWargaRepositoryAbstract::class, PendapatWargaRepository::class);
        $this->app->bind(LaporanInformasiRepositoryAbstract::class, LaporanInformasiRepository::class);
        $this->app->bind(ProblemSolvingRepositoryAbstract::class, ProblemSolvingRepository::class);
        $this->app->bind(UserRepositoryAbstract::class, UserRepository::class);
        $this->app->bind(RoleRepositoryAbstract::class, RoleRepository::class);
        $this->app->bind(NIBRepositoryAbstract::class, NIBRepository::class);
        $this->app->bind(ChecklistRepositoryAbstract::class, ChecklistRepository::class);
        $this->app->bind(RiwayatSioRepositoryAbstract::class, RiwayatSioRepository::class);
        $this->app->bind(PersonelRepositoryAbstract::class, PersonelRepository::class);
        $this->app->bind(KlasterRutinitasRepositoryAbstract::class, KlasterRutinitasRepository::class);
        $this->app->bind(AkumulasiLaporanBhabinkamtibmasRepositoryAbstract::class, AkumulasiLaporanBhabinkamtibmasRepository::class);
        $this->app->bind(BUJPRepositoryAbstract::class, BUJPRepository::class);
        $this->app->bind(SatpamRepositoryAbstract::class, SatpamRepository::class);
        $this->app->bind(BerkasPendaftaranSioRepositoryAbstract::class, BerkasPendaftaranSioRepository::class);
        $this->app->bind(TagRepositoryAbstract::class, TagRepository::class);
        $this->app->bind(PaparanRepositoryAbstract::class, PaparanRepository::class);
        $this->app->bind(StatusSioRepositoryAbstract::class, StatusSioRepository::class);
        $this->app->bind(KawasanRepositoryAbstract::class, KawasanRepository::class);
        $this->app->bind(LaporanPublikRepositoryAbstract::class, LaporanPublikRepository::class);
        $this->app->bind(LaporanBhabinkamtibmasRepositoryAbstract::class, LaporanBhabinkamtibmasRepository::class);
        $this->app->bind(LaporanSatpamRepositoryAbstract::class, LaporanSatpamRepository::class);
        $this->app->bind(PSNonSengketaRepositoryAbstract::class, PSNonSengketaRepository::class);
        $this->app->bind(SatuanRepositoryAbstract::class, SatuanRepository::class );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
