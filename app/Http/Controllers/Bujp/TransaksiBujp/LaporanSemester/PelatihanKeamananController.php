<?php

namespace App\Http\Controllers\Bujp\TransaksiBujp\LaporanSemester;

use App\Exports\Bujp\LaporanSemester\PelatihanKeamananExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bujp\LaporanSemester\PelatihanKeamananRequest;
use App\Models\Bujp;
use App\Services\TransaksiBujp\LaporanSemester\PelatihanKeamananService;
use Illuminate\Http\Request;
use App\Models\Bujp\LaporanSemester\PelatihanKeamanan;
use Maatwebsite\Excel\Facades\Excel;

class PelatihanKeamananController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new PelatihanKeamananService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bujp.transaksi-bujp.laporan-semester.pelatihan-keamanan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bujp = auth()->user()->bujp;
        return view('bujp.transaksi-bujp.laporan-semester.pelatihan-keamanan.create', compact('bujp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PelatihanKeamananRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->user()->id;

        $data['bujp_id'] = strtolower(auth()->user()->bujp->nama_badan_usaha) === strtolower($data['nama_bujp'])
            ? auth()->user()->bujp?->id
            : Bujp::firstWhere('nama_badan_usaha', 'ilike', '%' . $data['nama_bujp'] . '%')?->id;
        unset($data['nama_bujp']);

        if($data['bujp_id'] === null) {
            $this->flashError('Nama Bujp Tidak Ditemukan didalam sistem kami!');
            return redirect()->back()->withInput();
        }

        // Mengganti beberapa escape character dengan menggunakan array dan preg_replace
        $search = array('/\\r\\n|\\n/', '/\\t/', "/\\'/");
        $replace = array('<br>', '&nbsp;&nbsp;&nbsp;&nbsp;', '&apos;');

        $data['fasilitas'] = preg_replace($search, $replace, $data['fasilitas']);

        PelatihanKeamanan::create($data);

        $this->flashSuccess('Berhasil Membuat Laporan!');
        return redirect()->route('pelatihan-keamanan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pelatihanKeamanan = PelatihanKeamanan::findOrFail($id);

        return view('bujp.transaksi-bujp.laporan-semester.pelatihan-keamanan.edit', compact('pelatihanKeamanan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PelatihanKeamananRequest $request, $id)
    {
        $data = $request->validated();

        $pelatihanKeamanan = PelatihanKeamanan::findOrFail($id);

        if(strtolower($data['nama_bujp']) !== strtolower($pelatihanKeamanan->bujp->nama_badan_usaha)) {
            $data['bujp_id'] = Bujp::firstWhere('nama_badan_usaha', 'ilike', '%' . $data['nama_bujp'] . '%')?->id;
            unset($data['nama_bujp']);

            if($data['bujp_id'] === null) {
                $this->flashError('Nama Bujp Tidak Ditemukan didalam sistem kami!');
                return redirect()->back()->withInput();
            }
        }

        // Mengganti beberapa escape character dengan menggunakan array dan preg_replace
        $search = array('/\\r\\n|\\n/', '/\\t/', "/\\'/");
        $replace = array('<br>', '&nbsp;&nbsp;&nbsp;&nbsp;', '&apos;');
        $data['fasilitas'] = preg_replace($search, $replace, $data['fasilitas']);

        if($data['tempat_diklat'] === 'milik sendiri') {
            $data['pihak_yang_menyewakan_tempat'] = null;
        }

        $pelatihanKeamanan->update($data);

        $this->flashSuccess('Berhasil Mengedit data Laporan Semester Jasa Pelatihan keamanan!');
        return redirect()->route('pelatihan-keamanan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pelatihanKeamanan = PelatihanKeamanan::findOrFail($id);

        $pelatihanKeamanan->delete();

        $this->flashSuccess('Berhasil Menghapus Laporan Semester Jasa Pelatihan keamanan yang dipilih!');
        return redirect()->route('pelatihan-keamanan.index');
    }

    public function search(Request $request)
    {
        $result = $this->service->search($request);
        return response()->json($result);
    }

    public function exportExcel(Request $request)
    {
        $template = new TemplateLaporan();
        return Excel::download($template, 'Laporan Semester Data Jasa Pelatihan Keamanan - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }
}
