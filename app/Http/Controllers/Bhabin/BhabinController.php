<?php

namespace App\Http\Controllers\Bhabin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bhabin\LokasiPenugasan\StoreLokasiPenugasanRequest;
use App\Models\Bhabin;
use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use App\Models\LaporanPublik;
use App\Models\Personel;
use App\Models\Problem_solving;
use App\Models\PsNonSengketa;
use Detection\MobileDetect;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class BhabinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $detect = new MobileDetect();

        if (role('bhabinkamtibmas')) {
            $personel = $user->personel;
        } elseif (role('polsus')) {
            $personel = $user->polsus;
        } elseif (role('satpam')) {
            $personel = $user->satpam;
        }

        $viewProfile = !$detect->isMobile() && !$detect->isTablet()
            ? 'bhabin.tampilan-baru.profile'
            : 'bhabin.profile';

        return view($viewProfile, [
            'personel' => $personel,
            'nrp' => $user->nrp,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function storeLokasi(StoreLokasiPenugasanRequest $request)
    {
        dd($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Bhabin $bhabin)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bhabin $bhabin)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bhabin $bhabin)
    {
    }

    public function pdf(Request $request)
    {
        $request->validate([
            'dari' => 'required|date',
            'sampai' => 'required|date',
        ]);

        $dari = Carbon::parse($request->dari)->format('Y-m-d 00:00:00');
        $sampai = Carbon::parse($request->sampai)->format('Y-m-d 23:59:59');
        $formattedDari = Carbon::parse($dari)->locale('id')->translatedFormat(config('app.long_date_format'));
        $formattedSampai = Carbon::parse($sampai)->locale('id')->translatedFormat(config('app.long_date_format'));

        $dds = Dds_warga::query()
            ->with('laporan_informasi', 'pendapat_warga:dds_warga_id,jenis_pendapat,uraian')
            ->where(function ($query) use ($sampai, $dari) {
                $this->query($query, $dari, $sampai);
            })->get()->unique('laporan_informasi.uraian')->values()->toArray();

        $deteksi_dini = Deteksi_dini::query()
            ->with('laporan_informasi:form_id,form_type,uraian')
            ->where(function ($query) use ($sampai, $dari) {
                $this->query($query, $dari, $sampai);
            })->get()->unique('laporan_informasi.uraian')->values()->toArray();

        $ps1 = Problem_solving::query()
            ->where(function ($query) use ($sampai, $dari) {
                $this->query($query, $dari, $sampai);
            })->get([
                'tanggal', 'waktu_kejadian', 'hari_masalah_selesai', 'tanggal_masalah_selesai',
                'nama_narasumber', 'alamat_narasumber', 'nama_pihak_1', 'alamat_pihak_1',
                'nama_pihak_2', 'alamat_pihak_2', 'saksi', 'uraian_kejadian', 'uraian_problem_solving',
            ])->unique('uraian_kejadian')->values()->toArray();

        $ps2 = PsNonSengketa::query()
            ->where(function ($query) use ($sampai, $dari) {
                $this->query($query, $dari, $sampai);
            })->get([
                'tanggal_kejadian', 'waktu_kejadian', 'tanggal_selesai',
                'nama_narasumber', 'pihak_terlibat', 'uraian_masalah',
                'uraian_solusi',
            ])->unique('uraian_masalah')->values()->toArray();

        $lokasi = explode(',', auth()->user()->lokasiPenugasans()->first()->lokasi);

        if (!(count($dds) || count($deteksi_dini) || count($ps1) || count($ps2))) {
            $this->flashWarning('Data Laporan pada '.$formattedDari.' sampai '.$formattedSampai.' tidak ditemukan');

            return back();
        }

        $pdf = \PDF::loadView('bhabin.laporan_pdf',
            compact('formattedDari', 'formattedSampai', 'dds', 'lokasi', 'deteksi_dini', 'ps1', 'ps2'))
            ->setPaper('a4', 'potrait');

        return $pdf->stream('laporan.pdf');
    }

    public function updatePhoneNumber(Request $request)
    {
        $validated = $request->validate([
            'handphone' => 'nullable|numeric|digits_between:9,31',
        ]);

        if (!$request->has('handphone')) {
            Personel::where('user_id', auth()->user()->id)->update([
                'last_handphone_update' => now()->format('Y-m-d H:i:s'),
            ]);

            return response()->json([
                'message' => 'nomor handphone anda tidak berubah',
            ]);
        }

        Personel::where('user_id', auth()->user()->id)->update([
            'handphone' => $validated['handphone'],
            'last_handphone_update' => now()->format('Y-m-d H:i:s'),
        ]);

        $this->flashSuccess('nomor handphone berhasil diperbarui');

        return redirect()->back();
    }

    public function getDatatablePenggunaPublikLaporan(Request $request)
    {
        $user_locations = auth()->user()->lokasiPenugasans();
        $village_codes = $user_locations->pluck('village_code')->toArray();
        $district_codes = $user_locations->pluck('district_code')->toArray();

        $model = LaporanPublik::class;
        $model = addcslashes($model, '\\');

        $query = LaporanPublik::query()
            ->with('laporan_informasi.keywords:keyword')
            ->when(!empty($village_codes), fn ($q) => $q->whereIn('village_code', $village_codes))
            ->when(!empty($district_codes), fn ($q) => $q->whereIn('district_code', $district_codes));

        try {
            $date = Carbon::createFromFormat('Y-m', $request->bulan);
        } catch (\Exception $e) {
            $date = Carbon::now();
        }

        $query->whereBetween('created_at', [
            $date->startOfMonth()->format('Y-m-d H:i:s'),
            $date->endOfMonth()->format('Y-m-d H:i:s'),
        ]);

        return DataTables::eloquent($query)
            ->addColumn(
                'keyword',
                fn ($c) => isset($c->laporan_informasi->keywords)
                    ? $c->laporan_informasi->keywords->implode('keyword', ', ')
                    : ''
            )
            ->addColumn(
                'lokasi',
                function ($laporan) {
                    $desa = $laporan->desa ? $laporan->desa.', ' : '';
                    $kecamatan = $laporan->kecamatan ? $laporan->kecamatan.', ' : '';
                    $kabupaten = $laporan->kabupaten ? $laporan->kabupaten.', ' : '';
                    $provinsi = $laporan->provinsi ? $laporan->provinsi : '';

                    return $desa.$kecamatan.$kabupaten.$provinsi;
                }
            )
            ->addColumn(
                'action',
                function ($laporan) use ($model) {
                    $escalateBtn = '<button '
                        .'type="button"'
                        .'class="btn btn-sm btn-info"'
                        .'data-bs-toggle="modal"'
                        .'data-bs-target="#eskalasiLaporan"'
                        .'onclick="loadEskalasi('.$laporan->id.', \''.$model.'\')"'
                        .'title="Eskalasi Laporan"'
                    .'>'
                        .'<i class="fa fa-level-up-alt" aria-hidden="true"></i>'
                    .'</button>';

                    $commentBtn = '<button '
                        .'type="button"'
                        .'class="btn btn-sm btn-info"'
                        .'data-bs-toggle="modal"'
                        .'data-bs-target="#komentarEskalasiLaporan"'
                        .'onclick="loadKomentarEskalasiLaporan('.$laporan->id.', \''.$model.'\')"'
                        .'title="Tambah Komentar"'
                    .'>'
                        .'<i class="far fa-comment" aria-hidden="true"></i>'
                    .'</button>';

                    return '<div class="row" style="column-gap: 0.4rem; row-gap: 0.4rem">'
                        .'<div class="col">'.$escalateBtn.'</div>'
                        .'<div class="col">'.$commentBtn.'</div>'
                    .'</div>';
                }
            )
            ->rawColumns(['action'])
            ->toJson();
    }

    private function query($query, $from, $to)
    {
        return $query->where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$from, $to]);
    }
}
