<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataPranataExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\DataPranata\StoreRequest;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binpolmas\DataPranata;
use App\Models\User;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataPranataService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;

class DataPranataController extends Controller
{
    protected $model = DataPranata::class;

    private $DataPranataService;

    public function __construct()
    {
        $this->DataPranataService = new DataPranataService();
    }

    public function index()
    {

        return view('administrator.sislap.lapsubjar.binpolmas.data-pranata.index', [
            'columns' => $this->DataPranataService->columns,
            'model' => addcslashes($this->model, "\\")
        ]);


    }

    public function create()
    {
        return view("administrator.sislap.lapsubjar.binpolmas.data-pranata.create");
    }

    public function store(StoreRequest $request)
    {
        $user = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level = end($levels);
        $kode_satuan = $user->personel->kode_satuan;

        /**
         * Handle user tidak memiliki personel dan kode satuan
         */

        if (empty($kode_satuan)) {
            throw ValidationException::withMessages([
                'kode_satuan' => 'Anda tidak memiliki satuan kerja'
            ])->redirectTo(route('data-pranata.index'));
        }

        $validated = $request->validated();
        try {

            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                if(array_key_exists( "laporan", $validated)) {
                    foreach ($validated['laporan'] as $item) {
                        $laporan = DataPranata::create(array_merge($item, [
                            'user_id' => $user->id,
                            'kode_satuan' => $kode_satuan,
                        ]));

                        if ($level === 'polda') {
                            $laporan->approvals()->create([
                                'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                                'level' => $level,
                            ]);
                        }
                    }
                    $this->flashSuccess('Berhasil menambahkan laporan');
                } else {
                    foreach ($validated['data'] as $item) {
                        $laporan = DataPranata::create(array_merge($item, [
                            'user_id' => $user->id,
                            'kode_satuan' => $kode_satuan,
                        ]));

                        if ($level === 'polda') {
                            $laporan->approvals()->create([
                                'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                                'level' => $level,
                            ]);
                        }
                    }
                }
            });
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-pranata.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validated = $request->all();
        try {
            DataPranata::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-pranata.index');
    }

    public function destroy($id)
    {
        try {
            DataPranata::where('id', $id)->delete();
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

        return (new DataPranataExport(true))
            ->download('Format Laporan Data Pranata'
                .$additionalName.' '
                .now()->format('Y-m-d')
                .'.xlsx'
            );
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));
        return view('administrator.sislap.lapsubjar.binpolmas.data-pranata.index', [
            'laporan' => $data,
            'columns' => $this->DataPranataService->columns,
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
        return (new DataPranataExport())
            ->download('Laporan Data Pranata '
               .$additionalNotes
               .'.xlsx'
            );
    }

    public function search(Request $request)
    {
        $collection = $this->DataPranataService->search($request);
        return response()->json($collection);
    }

    public function getListPolres(Request $request)
    {
        $kode_satuan = auth()->user()->personel->kode_satuan;
        $polda       = auth()->user()->personel->polda;
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        $polres_sudah_lapor =  DataPranata::whereDate('created_at', $request->date)
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