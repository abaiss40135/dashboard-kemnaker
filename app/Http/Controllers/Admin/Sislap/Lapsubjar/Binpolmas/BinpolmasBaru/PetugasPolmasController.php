<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\PetugasPolmasExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\PetugasPolmas\StoreRequest;
use App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\PetugasPolmas\UpdateRequest;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binpolmas\PetugasPolmas as Model;
use App\Models\User;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\PetugasPolmasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;

class PetugasPolmasController extends Controller
{
    private $model = Model::class;

    protected $petugasPolmasService;

    public function __construct()
    {
        $this->petugasPolmasService = new PetugasPolmasService();
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.petugas-polmas.index', [
            'columns' => $this->petugasPolmasService->columns,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("administrator.sislap.lapsubjar.binpolmas.petugas-polmas.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user()?->load('personel');
        $levels = explode('_', $user->role());
        $level = end($levels);
        $kode_satuan = $user->personel->kode_satuan;

        /**
         * Handle user tidak memiliki personel dan kode satuan
         */
        if (empty($kode_satuan)) {
            throw ValidationException::withMessages([
                'kode_satuan' => 'Anda tidak memiliki satuan kerja'
            ])->redirectTo(route('petugas-polmas-kawasan-wilayah.index'));
        }

        try {
            DB::transaction(function () use ($level, $user, $data, $kode_satuan) {
                foreach($data["laporan"] as $laporan) {
                    $this->uploadPath   = 'binpolmas';
                    $this->folderName   = 'petugas-polmas';
                    $this->fileName     = (auth()->user()?->personel?->nama ?? "file") . " - " . $laporan["lampiran_file"]->getClientOriginalName();

                    $uploadedFileName = $this->saveFiles($laporan["lampiran_file"]);
                    // upload file
                    $laporan['lampiran_file'] = $uploadedFileName;

                    $petugasPolmas = Model::query()
                        ->create(array_merge($laporan, [
                            'user_id' => $user->id,
                            'kode_satuan' => $kode_satuan
                        ]));

                    if ($level === 'polda') {
                        $petugasPolmas->approvals()->create([
                            'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level' => $level,
                        ]);
                    }
                }
            });

            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $e) {
            $this->flashError($e->getMessage());
        }

        return redirect()->route('petugas-polmas-kawasan-wilayah.index');
    }

    public function storeForm(Request $request)
    {
        $data = $request->validate([
            'polda' => 'required|string',
            'polres' => 'required|string',
            'jumlah_rw' => 'required|integer',
            'jumlah_petugas_wilayah' => 'required|integer',
            'jumlah_petugas_kawasan' => 'required|integer',
            'jumlah_sdh_pelatihan_polmas' => 'required|integer',
            'lampiran_file' => 'required|file',
        ]);

        $user = auth()->user()?->load('personel');
        $levels = explode('_', $user->role());
        $level = end($levels);
        $kode_satuan = $user->personel->kode_satuan;

        try {
            $this->uploadPath   = 'binpolmas';
            $this->folderName   = 'petugas-polmas';
            $this->fileName     = (auth()->user()?->personel?->nama ?? "file") . " - " . $data["lampiran_file"]->getClientOriginalName();

            $uploadedFileName = $this->saveFiles($data["lampiran_file"]);
            // upload file
            $data['lampiran_file'] = $uploadedFileName;

            $petugasPolmas = Model::query()
                ->create(array_merge($data, [
                    'user_id' => $user->id,
                    'kode_satuan' => $kode_satuan
                ]));

            if ($level === 'polda') {
                $petugasPolmas->approvals()->create([
                    'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                    'level' => $level,
                ]);
            }

            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $e) {
            $this->flashError($e->getMessage());
        }

        return redirect()->route('petugas-polmas-kawasan-wilayah.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\PetugasPolmas\UpdateRequest $request
     * @param  int  $id
     * @return
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $petugasPolmas = Model::find($id);

        try {
            if(isset($data['lampiran_file'])) {
                $this->deleteFiles($petugasPolmas);

                $this->uploadPath   = 'binpolmas';
                $this->folderName   = 'pembina-polmas';
                $this->fileName     = (auth()->user()?->personel?->nama ?? "file") . " - " . $data["lampiran_file"]->getClientOriginalName();

                // upload file
                $uploadedFileName = $this->saveFiles($data['lampiran_file']);
                $data['lampiran_file'] = $uploadedFileName;
            }

            $petugasPolmas->update($data);

            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('petugas-polmas-kawasan-wilayah.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        try {
            $data = Model::find($id);

            $this->deleteFiles($data->lampiran_file);

            $data->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->back();
    }

    public function templateExcel()
    {
        $additionalName = '';
        if (auth()->user()->haveRoleID([User::BINPOLMAS_POLDA, User::BINPOLMAS_POLRES])) {
            $additionalName .= (' '.auth()->user()->personel->polda);
            if (auth()->user()->haveRoleID(User::BINPOLMAS_POLRES)) {
                $additionalName .= (' '.auth()->user()->personel->polres);
            }
        }

        return (new PetugasPolmasExport(true))
            ->download('FORMAT LAPORAN DATA PETUGAS POLMAS MODEL KAWASAN DAN MODEL WILAYAH '
                .$additionalName.' '
                .now()->format('Y-m-d')
                .'.xlsx'
            );
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));
        return view('administrator.sislap.lapsubjar.binpolmas.petugas-polmas.index', [
            'laporan' => $data,
            'columns' => $this->petugasPolmasService->columns,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel()
    {
        $additionalNotes = '';
        $request = request()->collect()->filter(function ($item, $key){
            return $key !== '_token' && !is_null($item);
        })->unique();
        if (count($request)){
            $additionalNotes .= ' '.implode(' ', $request->toArray());
        }
        return (new PetugasPolmasExport(false))
            ->download('EKSPOR LAPORAN PETUGAS POLMAS MODEL KAWASAN DAN MODEL WILAYAH  '
                .$additionalNotes
                .'.xlsx'
            );
    }

    public function search(Request $request)
    {
        $collection = $this->petugasPolmasService->search($request);
        return response()->json($collection);
    }

    public function getListPolres(Request $request)
    {
        $kode_satuan = auth()->user()->personel->kode_satuan;
        $polda       = auth()->user()->personel->polda;
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        $polres_sudah_lapor =  Model::whereDate('created_at', $request->date)
            ->where('polda', $polda)->pluck('id', 'polres')->toArray();

        $status_lapor = [];
        $can_send_approval = true;

        foreach($polres_list as $item) {
            $status = Collect(array_keys($polres_sudah_lapor))->contains($item['nama_satuan']);
            $status_lapor[] = [
                'nama_satuan' => $item['nama_satuan'],
                'status' => $status,
            ];
            $can_send_approval = $can_send_approval && $status;
        };

        return response()->json([
            'status_lapor' => $status_lapor,
            'can_send_approval' => $can_send_approval,
            'laporan_ids' => Collect(array_values($polres_sudah_lapor))
        ]);
    }
}
