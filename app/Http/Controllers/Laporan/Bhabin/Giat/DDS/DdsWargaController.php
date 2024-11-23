<?php

namespace App\Http\Controllers\Laporan\Bhabin\Giat\DDS;

use App\Http\Requests\Bhabin\Laporan\DDSWarga\StoreDDSWargaRequest;
use App\Http\Requests\Bhabin\Laporan\DDSWarga\UpdateDDSWargaRequest;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\DDSWargaServiceInterface;
use App\Services\ProvinsiService;
use PDF;
use Illuminate\Support\Facades\DB;

class DdsWargaController extends Controller
{
    private $provinsiService,
            $DDSWargaService;

    public function __construct(
            DDSWargaServiceInterface $DDSWargaService,
            ProvinsiService $provinsiService
        )
    {
        $this->provinsiService  = $provinsiService;
        $this->DDSWargaService  = $DDSWargaService;
    }

    public function getDatatable()
    {
        if (request()->ajax()) {
            return $this->DDSWargaService->getDatatable();
        }
    }

    public function index()
    {
        return view('bhabin.laporan.giat.dds.warga.index', [
            'countLaporan' => $this->DDSWargaService->countDds()
        ]);
    }

    public function create($id = null)
    {
        $data['existing_data'] = null;
        $data['count_exist_laporan'] = 0;

        if ($id) {
            $data['existing_data'] = $this->DDSWargaService->getExistData($id);
            $data['count_exist_laporan'] = $this->DDSWargaService
                ->getExistLaporan($data['existing_data']->nama_kepala_keluarga);
        }

        $data['provinsi']   = $this->provinsiService->getSelectProvinsiData()->sortBy('id');
        return view('bhabin.laporan.giat.dds.warga.create', $data);
    }

    public function store(StoreDDSWargaRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->DDSWargaService->store($request->validated());
            DB::commit();
            $this->flashSuccess('Berhasil menambahkan data');
            return redirect()->route('dds-warga.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show($id)
    {
        return $this->DDSWargaService->show($id);
    }

    public function edit($id)
    {
        $data['laporan'] = $this->DDSWargaService->show($id);
        if (!$data['laporan']) {
            $this->flashError('Anda tidak memiliki hak akses ke laporan ini.');
            return redirect()->back();
        }

        $data['pendapat_wargas'] = $data['laporan']['pendapat_warga']
            ->groupBy('jenis_pendapat')
            ->map(fn ($val, $key) => $val->first());

        $data['provinsi']   = $this->provinsiService->getSelectProvinsiData();

        return view('bhabin.laporan.giat.dds.warga.edit', $data);
    }

    public function update(UpdateDDSWargaRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->DDSWargaService->update($request->validated(), $id);
            DB::commit();
            $this->flashSuccess('Berhasil mengupdate data');
            return redirect()->route('dds-warga.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $state = $this->DDSWargaService->delete($id);
            DB::commit();
            $this->responseSuccess([
                'message' => 'Data DDS berhasil dihapus'
            ]);
            return $state;
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->responseError($exception);
        }
    }

    public function pdf($id)
    {
        $data['data']    = $this->DDSWargaService->show($id);
        $data['anggotaKeluarga'] = $data['data']['anggota_keluargas'];
        $data['laporanInformasi'] = $data['data']['laporan_informasi'];
        $pdf = PDF::loadView('bhabin.laporan.giat.dds.warga.pdf', $data)
        ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan.pdf');
    }

    public function getKepalaKeluarga()
    {
        return $this->DDSWargaService->getSelectKepalaKeluarga();
    }

    public function getLatestReport() {
        $data = $this->DDSWargaService->getLatestFromAuthUser();

        return response()->json($data);
    }
}
