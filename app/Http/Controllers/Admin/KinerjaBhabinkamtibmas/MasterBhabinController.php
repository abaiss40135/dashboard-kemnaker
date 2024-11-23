<?php

namespace App\Http\Controllers\Admin\KinerjaBhabinkamtibmas;

use App\Exports\KinerjaBhabinkamtibmas\ListSatuanBhabinkamtibmasExport;
use App\Exports\LaporanBhabinkamtibmasExport;
use App\Exports\UraianLaporanBhabinkamtibmasExport;
use App\Helpers\ApiHelper;
use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Models\AkumulasiLaporanBhabinkamtibmas;
use App\Models\Provinsi;
use App\Models\User;
use App\Repositories\Abstracts\LokasiPenugasanRepositoryAbstract;
use App\Repositories\Abstracts\UserRepositoryAbstract;
use App\Repositories\Export\MasterBhabin\ExcelKlasterBhabin;
use App\Services\DDSWargaService;
use App\Services\Interfaces\DDSWargaServiceInterface;
use App\Services\Interfaces\KecamatanServiceInterface;
use App\Services\Interfaces\KlasterRutinitasServiceInterface;
use App\Services\Interfaces\KotaServiceInterface;
use App\Services\Interfaces\ProvinsiServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;

class MasterBhabinController extends Controller
{
    protected $DDSWargaService;
    protected $provinsiService;
    protected $kotaService;
    protected $kecamatanService;

    /**
     * @var KlasterRutinitasServiceInterface
     */
    private $klasterRutinitasService;
    /**
     * @var LokasiPenugasanRepositoryAbstract
     */
    private $lokasiPenugasanRepository;
    private $userRepository;

    public function __construct(
        ProvinsiServiceInterface $provinsiService,
        KotaServiceInterface $kotaService,
        KecamatanServiceInterface $kecamatanService,
        DDSWargaServiceInterface $DDSWargaService,
        KlasterRutinitasServiceInterface $klasterRutinitasService,
        LokasiPenugasanRepositoryAbstract $lokasiPenugasanRepository,
        UserRepositoryAbstract $userRepository
    ) {
        $this->provinsiService = $provinsiService;
        $this->kotaService = $kotaService;
        $this->kecamatanService = $kecamatanService;
        $this->DDSWargaService = $DDSWargaService;
        $this->klasterRutinitasService = $klasterRutinitasService;
        $this->lokasiPenugasanRepository = $lokasiPenugasanRepository;
        $this->userRepository = $userRepository;
    }

    public function getDatatable()
    {
        return $this->klasterRutinitasService->getDatatable();
    }

    private function countLoggedInPerPolda()
    {
        $listLoginPerPolda = [];
        foreach ($this->provinsiService->getDataAndKeyByCode() as $code => $name) {
            $listLoginPerPolda[] = Cache::remember('countLoggedInPerPolda'.$code, defaultCacheTime(Constants::CACHE1DAY), fn () => User::query()
                ->isBhabinkamtibmas()
                ->has('personel')
                ->whereNotNull('last_login_at')
                ->whereHas('lokasiPenugasans', fn ($lp) => $this->lokasiPenugasanRepository->filterData(['province_code' => $code], $lp))
                ->count()
            );
        }

        return $listLoginPerPolda;
    }

    private function listBhabinPerPolda()
    {
        $bhabinPerPolda = $this->provinsiService->getDataAndKeyByCode()->pluck('jumlah_bhabin')->toArray();
        $loggedIn = $this->countLoggedInPerPolda();
        $chart1Jumlah = array_slice($bhabinPerPolda, 0, 17);
        $chart2Jumlah = array_slice($bhabinPerPolda, 17);
        $chart1loggedIn = array_slice($loggedIn, 0, 17);
        $chart2loggedIn = array_slice($loggedIn, 17);

        return [[$chart1Jumlah, $chart1loggedIn], [$chart2Jumlah, $chart2loggedIn]];
    }

    private function countLaporanSepekan($user_id)
    {
        $jumlah = 0;
        $date = Carbon::today()->subWeeks(2);

        $daftarLaporan = [
            DB::table('problem_solvings'),
            DB::table('dds_wargas'),
            DB::table('deteksi_dinis'),
            DB::table('ps_eksekutifs'),
            DB::table('ps_non_sengketas'),
        ];

        foreach ($daftarLaporan as $laporan) {
            $jumlah += $laporan->where('user_id', $user_id)
                ->where('created_at', '>', $date)->count();
        }

        return $jumlah;
    }

    private function setKlasterRutinitas($user_id)
    {
        $jumlah = $this->countLaporanSepekan($user_id);
        if ($jumlah >= 4) {
            return ['keaktifan' => 'Aktif', 'warna' => 'info'];
        } elseif ($jumlah >= 1) {
            return ['keaktifan' => 'Cukup Aktif', 'warna' => 'warning'];
        } else {
            return ['keaktifan' => 'Kurang Aktif', 'warna' => 'danger', 'jumlah' => $jumlah];
        }
    }

    private function getBhabinList($query)
    {
        $query->each(function ($bhabin, $key) {
            $bhabin->profile = ApiHelper::getBhabinByNrp($bhabin->nrp);
            $bhabin->klaster_rutinitas = $this->setKlasterRutinitas($bhabin->id);
        });

        return $query;
    }

    public function index()
    {
        return view('administrator.kinerja-bhabinkamtibmas.index', [
            'periods' => $this->getPeriode(),
        ]);
    }

    public function getPeriode()
    {
        return Cache::remember('getPeriodeLaporanFor'.auth()->user()->personel->polda ?? auth()->user()->id, defaultCacheTime(Constants::CACHE1HOUR), function () {
            return \App\Models\AkumulasiLaporanBhabinkamtibmas::selectRaw('DISTINCT periode')
                ->when(auth()->user()->haveRoleID([User::OPERATOR_BHABINKAMTIBMAS_POLDA, User::OPERATOR_BHABINKAMTIBMAS_POLRES]), function ($query) {
                    $query->whereHas('personel', function ($query) {
                        $query->where('satuan1', auth()->user()->personel->satuan1);
                    });
                })
                ->whereBetween('periode', ['2019-05', now()->format('Y-m')])
                ->orderByDesc('periode')->pluck('periode')
                ->unique()->map(function ($item) {
                    return [
                        'id' => $item,
                        'text' => strtoupper(Carbon::parse($item)->translatedFormat('F Y')),
                    ];
                })->values()->toArray();
        });
    }

    public function showPaginate()
    {
        $queryUser = User::hasNrp()->isBhabinkamtibmas();
        if (role('operator_bhabinkamtibmas_polda')) {
            $province_code = Provinsi::where('polda', Str::between(auth()->user()->personel->satuan1, 'POLDA ', '-'))->first(['code'])->code;
            $queryUser->whereHas('lokasiPenugasans', function ($query) use ($province_code) {
                $query->where('province_code', $province_code);
            });
        }

        $query = $this->getBhabinList($queryUser->paginate(10));

        return response()->json($query);
    }

    public function getPolda(Request $request)
    {
        $polda = DB::table('provinces')->where('polda', Lang::get('abbreviation')[$request->polda])->first(['code'])->code;

        $data = User::hasNrp()->isBhabinkamtibmas()
            ->whereHas('lokasiPenugasans', function ($query) use ($polda) {
                $query->where('province_code', $polda);
            })->paginate(10);

        $data->each(function ($item, $key) {
            $item->profile = ApiHelper::getBhabinByNrp($item->nrp);
            $item->klaster_rutinitas = $this->setKlasterRutinitas($item->id);
        });

        return response()->json($data);
    }

    public function chart()
    {
        $listProvinsi = $this->provinsiService->getDataAndKeyByCode();
        $loginPerPolda = $this->countLoggedInPerPolda();
        $jumlahBhabin = User::isBhabinkamtibmas()
            ->has('personel')
            ->selectRaw('CASE WHEN last_login_at IS NULL THEN 0 ELSE 1 END AS is_logged_in')
            ->get()->countBy('is_logged_in');
        $notLogin = $jumlahBhabin[0];
        $hasLogin = $jumlahBhabin[1];

        return response()->json([
            'jumlahBhabin' => 38995,
            'rekapitulasi' => $this->listBhabinPerPolda(),
            'hasLogin' => $hasLogin,
            'notLogin' => $notLogin,
            'loginPerPolda' => $loginPerPolda,
            'listPolda' => $listProvinsi->pluck('polda'),
            'province_code' => $listProvinsi->keys(),
            'jumlahBhabinPerPolda' => $listProvinsi->pluck('jumlah_bhabin'),
        ]);
    }

    public function chartBhabin()
    {
        return response()->json([
            'labels' => $this->provinsiService->getDataAndKeyByCode()->pluck('polda'),
            'data' => $this->countLoggedInPerPolda(),
        ]);
    }

    private function countLoggedInPerPolres($polda)
    {
        $satuan1 = DB::table('personel')->where('satuan1', 'like', 'POLDA '.$polda.'-%')->first(['satuan1'])->satuan1;
        $kode_satuan = Str::after($satuan1, 'POLDA '.$polda.'-');

        $loginPerPolres = User::query()
            ->isBhabinkamtibmas()
            ->whereHas('personel', fn ($q) => $q->where('satuan1', 'like', 'POLDA '.$polda.'-%')->where('satuan2', 'like', 'POLRES%'))
            ->whereNotNull('last_login_at')
            ->get()
            ->countBy('personel.satuan2');

        try {
            $list_satuan = ApiHelper::getChildSatuanByKodeSatuan($kode_satuan, true);
            $nama_satuan = array_map(fn ($item) => $item['nama_satuan'], $list_satuan);

            $loginPerPolres = collect($loginPerPolres)->mapWithKeys(function ($item, $key) {
                return [Str::before($key, '-') => $item];
            });

            $loginPerPolres = collect($nama_satuan)->mapWithKeys(function ($item) use ($loginPerPolres) {
                return [$item => $loginPerPolres[$item] ?? 0];
            });

            return $loginPerPolres;
        } catch (\Exception $e) {
            $loginPerPolres = collect($loginPerPolres)->mapWithKeys(function ($item, $key) {
                return [Str::before($key, '-') => $item];
            });

            return $loginPerPolres;
        }
    }

    public function chartBhabinPolda(Request $request)
    {
        $loggedIn = $this->countLoggedInPerPolres($request->polda);
        $labels = $loggedIn->keys();
        $data = $loggedIn->values();

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function chartLaporan(Request $request)
    {
        $chartQuery = AkumulasiLaporanBhabinkamtibmas::selectRaw('
                SUM(CAST(jumlah_ps AS INT) + CAST(jumlah_ps_non_sengketa AS INT) + CAST(jumlah_ps_eksekutif AS INT)) AS ps,
                SUM(CAST(jumlah_dds AS INT)) AS dds,
                SUM(CAST(jumlah_deteksi_dini AS INT)) AS dd
            ');

        if ($request->polda) {
            $chartQuery->whereHas('personel', function ($query) use ($request) {
                $query->where('satuan1', 'ilike', $request->polda.'%');
            });
        }
        if (auth()->user()->haveRole('operator_bhabinkamtibmas_polda')) {
            $chartQuery->whereHas('personel', function ($query) {
                $query->where('satuan1', auth()->user()->personel->satuan1);
            });
        }
        if (auth()->user()->haveRole('operator_bhabinkamtibmas_polres')) {
            $chartQuery->whereHas('personel', function ($query) {
                $query->where('satuan2', auth()->user()->personel->satuan2);
            });
        }

        return response()->json($chartQuery->first());
    }

    public function search(Request $request)
    {
        $isLoggedIn = ($request->login == 'sudah') ? 'last_login_at IS NOT NULL ' : 'last_login_at IS ';
        $klaster = $request->klaster;

        $polda = $request->polda;

        if ($request->nrp != null) {
            $users = $this->getBhabinList(User::hasNrp()->isBhabinkamtibmas()
                ->where('nrp', 'like', '%'.$request->nrp.'%')
                ->select(['id', 'nrp', 'last_login_at'])->paginate(5));
        } else {
            if ($polda !== null) {
                $poldaCode = DB::table('provinces')->where('name', $request->polda)->pluck('code');
                $users = $this->getBhabinList(User::hasNrp()->isBhabinkamtibmas()
                    ->leftJoin('lokasi_penugasans', 'lokasi_penugasans.user_id', 'users.id')
                    ->where('lokasi_penugasans.province_code', $poldaCode)
                    ->select(['users.id', 'users.nrp', 'users.last_login_at'])->paginate(5, ['*'], 'polda_perpage'));
            } else {
                $queryUser = User::hasNrp()->isBhabinkamtibmas();
                $users = $this->getBhabinList($queryUser->paginate(45, ['id', 'nrp', 'last_login_at'], 'search-page'));
            }
        }
        // filtering klaster rutinitas
        $users->each(function ($item, $key) use ($klaster, $users) {
            $getKlaster = $this->setKlasterRutinitas($item->id);

            if (strtolower($getKlaster['keaktifan']) !== $klaster) {
                $users->forget($key);
            }
        });

        $users->paginate(5, ['id', 'nrp', 'last_login_at'], 'search-page');

        return response()->json($users);
    }

    public function excelKlaster()
    {
        $fileName = 'klasterisasi-bhabin-'.str_replace(' ', '-', strtolower(request()->polda)).
            '-'.Carbon::now()->isoFormat('D-MMMM-Y').'.xlsx';

        return (new ExcelKlasterBhabin(
            $this->userRepository
                ->getUserBhabinkamtibmasQuery(request()->all())
                ->with('personel', 'latest_klaster_rutinitas', 'latest_akumulasi_laporan')->get())
        )->download($fileName);
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportExcelUraianInformasi(Excel $excel, UraianLaporanBhabinkamtibmasExport $export, Request $request)
    {
        return $excel->download($export, 'Uraian Laporan Informasi Bhabinkamtibmas '.config('app.name').'.xlsx');
    }

    public function destroyDds($id)
    {
        DB::beginTransaction();
        try {
            $this->DDSWargaService->delete($id);
            DB::commit();
            $this->flashSuccess('DDS Warga berhasil dihapus');

            return back();
        } catch (\Exception $error) {
            DB::rollBack();
            $this->flashError($error->getMessage());

            return back();
        }
    }

    public function getPaginateDds(Request $request)
    {
        $dds_warga = DDSWargaService::getByNrp($request->nrp);

        return response()->json($dds_warga);
    }

    public function excelLaporanBhabinkamtibmas(Request $r)
    {
        $r = $r->validate([
            'nrp' => 'required',
            'month' => 'nullable',
        ]);

        $file = new LaporanBhabinkamtibmasExport($r['nrp'], $r['month']);

        return $file->download("LAPORAN BHABINKAMTIBMAS {$r['nrp']} {$r['month']}.xlsx");
    }

    public function excelListSatuan()
    {
        $file = new ListSatuanBhabinkamtibmasExport();

        return $file->download('LIST SATUAN.xlsx');
    }

    public function getSelectNamaBhabin(Request $request)
    {
        $result = [];
        $nama = $request->all()['nama'];

        if ($nama) {
            $query = User::with('lokasi_tugas')->doesntHave('mutasiUsers')
                ->isBhabinkamtibmas()
                ->join('personel', 'users.id', '=', 'personel.user_id')
                ->where('personel.nama', 'ilike', "%$nama%")
                ->select('personel.personel_id', 'personel.nama', 'users.id', 'users.nrp')
                ->get();

            foreach ($query as $data) {
                $result[] = [
                    'id' => $data->personel->personel_id,
                    'text' => $data->personel->nama.' | '.$data->nrp.' | '.($data?->lokasi_tugas?->lokasi ?? 'Belum mengatur lokasi tugas'),
                ];
            }
        } else {
            $result[] = [
                'id' => '0',
                'text' => 'Cari Bhabinkamtibmas berdasarkan nama!',
            ];
        }

        return $result;
    }
}
