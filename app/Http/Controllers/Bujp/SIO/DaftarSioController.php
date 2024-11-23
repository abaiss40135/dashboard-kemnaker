<?php

namespace App\Http\Controllers\Bujp\SIO;

use App\Http\Controllers\API\OSS\OSSController;
use App\Http\Controllers\Controller;
use App\Models\OSS\Checklist;
use App\Models\StatusSio;
use App\Services\Interfaces\ChecklistServiceInterface;
use App\Services\Interfaces\NIBServiceInterface;
use App\Services\Interfaces\ProvinsiServiceInterface;
use App\Services\Interfaces\RiwayatSioServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DaftarSioController extends Controller
{
    protected $nibService, $checklistService, $riwayatSioService, $provinsiService;

    /**
     * DaftarSioController constructor.
     */
    public function __construct(NIBServiceInterface $nibService, ChecklistServiceInterface $checklistService, RiwayatSioServiceInterface $riwayatSioService, ProvinsiServiceInterface $provinsiService)
    {
        $this->nibService = $nibService;
        $this->checklistService = $checklistService;
        $this->riwayatSioService = $riwayatSioService;
    }

    public function index()
    {
        if (request()->ajax()) {
            return $this->checklistService->getDatatable();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all( ));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id_izin, $pengajuan_id)
    {
        $checklist = $this->checklistService->show($id_izin)->load('nib', 'riwayatSio.dokumens.jenisBerkas','riwayatSio.statusSios');
        if ($checklist->nib->nib !== auth()->user()->bujp->nib){
            abort(403);
        }
        $pengajuan = $this->riwayatSioService->show($pengajuan_id);
        $data = [
            "checklist"         => $checklist,
            "status"            => StatusSio::orderBy('id')->pluck('status', 'id'),
            "pengajuan"         => $pengajuan->load('dokumens'),
            "logs"              => $pengajuan->log_statuses()->latest()->take(10)->get(),
            "riwayatPengajuan"  => $checklist->riwayatSios()->where('id', '!=', $pengajuan_id)->orderByDesc('tanggal_pengajuan')->limit(5)->get()
        ];
        return view('bujp.transaksi-bujp.pendaftaran-sio.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id_izin
     * @return \Illuminate\Http\Response
     */
    public function edit($idIzin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function previewFile(Checklist $checklist)
    {
        $path = 'temp/' . $checklist->id_izin . '.pdf';
        Storage::put($path, (new OSSController())->previewFile($checklist->file_ds->file_izin));
        return response()->file(Storage::path($path));
    }
}
