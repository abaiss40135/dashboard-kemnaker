<?php

namespace App\Http\Controllers\Bujp\TransaksiBujp\LaporanSemester;

use App\Exports\Bujp\LaporanSemester\TenagaPengamananExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bujp\LaporanSemester\TenagaPengamananRequest;
use App\Imports\Bujp\LaporanSemester\TenagaPengamananImport;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Bujp;
use App\Models\Bujp\LaporanSemester\TenagaPengamanan;
use App\Services\TransaksiBujp\LaporanSemester\TenagaPengamananService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TenagaPengamananController extends Controller
{
    public $model = TenagaPengamanan::class;
    private $service;


    public function __construct()
    {
        $this->service = new TenagaPengamananService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $periods = $this->service->getPeriods();
        return view('bujp.transaksi-bujp.laporan-semester.tenaga-pengamanan.index', [
            'model' => addcslashes($this->model, "\\"),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bujp = auth()->user()->bujp;
        $tenagaPengamanan = null;
        return view('bujp.transaksi-bujp.laporan-semester.tenaga-pengamanan.create', compact('bujp', 'tenagaPengamanan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TenagaPengamananRequest $request)
    {
        $latestLaporan = TenagaPengamanan::where('user_id', auth()->user()->id)->latest()->first();
        $semester = now()->month < 7 ? 1 : 2;
        $semesterOnLaporan = $latestLaporan ? ($latestLaporan->created_at->month < 7 ? 1 : 2) : 0;

        // laporan enam bulan sekali
        if($semesterOnLaporan === $semester) {
            $this->flashError('Anda sudah membuat laporan semester ini!');
            return redirect()->back();
        }


        $user = auth()->user();
        $levels = explode('_', $user->role());
        $level = end($levels);

        $data = $request->validated();

        $data['bujp_id'] = auth()->user()->bujp->nama_badan_usaha === $data['nama_bujp']
            ? auth()->user()->bujp?->id
            : Bujp::firstWhere('nama_badan_usaha', 'ilike', '%' . $data['nama_bujp'] . '%')?->id;
        unset($data['nama_bujp']);

        if($data['bujp_id'] === null) {
            $this->flashError('Nama Bujp Tidak Ditemukan didalam sistem kami!');
            return redirect()->back()->withInput();
        }

        $data['user_id'] = auth()->id();

        $tenagaPengamanan = TenagaPengamanan::create($data);

        $this->flashSuccess('Berhasil Membuat Laporan Semester - Jasa Penyedia Tenaga Pengamanan');
        return redirect()->route('tenaga-pengamanan.index');
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
        $tenagaPengamanan = TenagaPengamanan::findOrFail($id);
        $jumlahKualifikasi = $tenagaPengamanan->kualifikasi_gp + $tenagaPengamanan->kualifikasi_gm + $tenagaPengamanan->kualifikasi_gu;

        return view('bujp.transaksi-bujp.laporan-semester.tenaga-pengamanan.edit', compact('tenagaPengamanan', 'jumlahKualifikasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TenagaPengamananRequest $request, $id)
    {
        $data = $request->validated();
        $tenagaPengamanan = TenagaPengamanan::findOrFail($id);

        if(strtolower($data['nama_bujp']) !== strtolower($tenagaPengamanan->bujp->nama_badan_usaha)) {
            $data['bujp_id'] = auth()->user()->bujp->nama_badan_usaha === $data['nama_bujp']
                ? auth()->user()->bujp?->id
                : Bujp::firstWhere('nama_badan_usaha', 'ilike', '%' . $data['nama_bujp'] . '%')?->id;

            if($data['bujp_id'] === null) {
                $this->flashError('Nama Bujp Tidak Ditemukan didalam sistem kami!');
                return redirect()->back()->withInput();
            }
        }
        unset($data['nama_bujp']);

        $tenagaPengamanan->update($data);

        $this->flashSuccess('Berhasil Melakukan update data pada Laporan yang dipilih!');
        return redirect()->route('tenaga-pengamanan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tenagaPengamanan = TenagaPengamanan::findOrFail($id);
        $tenagaPengamanan->delete();

        $this->flashSuccess('Berhasil Menghapus Laporan!');
        return redirect()->route('tenaga-pengamanan.index');
    }

    public function search(Request $request)
    {
        $result = $this->service->search($request);

        return response()->json($result);
    }

    public function exportExcel(Request $request)
    {
        $template = new TemplateLaporan();
        return Excel::download($template, 'Laporan Semester Data Jasa Penyedia Tenaga Pengamanan - '.now()->translatedFormat(config('app.long_date_without_day_format')).'.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file-import' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = Excel::toArray(new ImportLaporan, $request->file('file-import'));

        $this->addFile($request->file('file-import'));

        $import = new TenagaPengamananImport();
        Excel::import($import, $this->path_file  , $this->disk);

        return redirect()->route('tenaga-pengamanan.index');
    }

    private function addFile($file)
    {
        $this->uploadPath = 'import/excel/bujp/laporan-semester/tenaga-pengamanan';
        $this->path_file = $this->saveFiles($file);
    }

    public function templateExcel(Request $request)
    {
        $template = new TemplateLaporan(true);
        return Excel::download($template, 'Template Laporan Semester Data Jasa Penyedia Tenaga Pengamanan.xlsx');
    }
}
