<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Exports\Sislap\Nonlapbul\PreemtifPmkExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\PreemtifPmk\StoreRequest;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\PreemtifPmk\UpdateRequest;
use App\Models\Sislap\Nonlapbul\PreemtifPmk;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Sislap\Nonlapbul\PreemtifPmkService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;

class PreemtifPmkController extends Controller
{
    protected $model = PreemtifPmk::class;

    private $preemtifPmkService;

    public function __construct()
    {
        $this->preemtifPmkService = new PreemtifPmkService();
    }

    public function index()
    {
        return view('administrator.sislap.nonlapbul.pmk.preemtif', [
            'columns' => $this->preemtifPmkService->columns,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function create()
    {
        //
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
            ])->redirectTo(route('preemtif-pmk.index'));
        }

        $validated = $request->validated();
        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach ($validated['laporan'] as $item) {
                    $laporan = PreemtifPmk::query()
                    ->whereDate('created_at', date('Y-m-d'))
                    ->updateOrCreate([
                        'polda' => $item['polda'],
                        'polres'=> $item['polres']
                    ], array_merge(Arr::except($item, ['polda', 'polres']), [
                        'user_id' => $user->id,
                        'kode_satuan' => $kode_satuan
                    ]));

                    if ($level === 'polda') {
                        $laporan->approvals()->create([
                            'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level' => $level,
                        ]);
                    }
                }
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('preemtif-pmk.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        try {
            PreemtifPmk::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('preemtif-pmk.index');
    }

    public function destroy($id)
    {
        try {
            PreemtifPmk::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel()
    {
        $additionalName = '';
        if (auth()->user()->haveRoleID([User::BAGOPSNALEV_POLDA, User::BAGOPSNALEV_POLRES])) {
            $additionalName .= (' '.auth()->user()->personel->polda);
            if (auth()->user()->haveRoleID(User::BAGOPSNALEV_POLRES)) {
                $additionalName .= (' '.auth()->user()->personel->polres);
            }
        }

        return (new PreemtifPmkExport(true))
            ->download('FORMAT LAPORAN KEGIATAN PREEMTIF PENANGANGAN PMK'
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
        return view('administrator.sislap.nonlapbul.pmk.preemtif', [
            'laporan' => $data,
            'columns' => $this->preemtifPmkService->columns,
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
        return (new PreemtifPmkExport())
            ->download('EKSPOR LAPORAN KEGIATAN PREEMTIF PENANGANGAN PMK '
               .$additionalNotes
               .'.xlsx'
            );
    }

    public function search(Request $request)
    {
        $collection = $this->preemtifPmkService->search($request);
        return response()->json($collection);
    }

    public function getListPolres(Request $request)
    {
        $kode_satuan = auth()->user()->personel->kode_satuan;
        $polda       = auth()->user()->personel->polda;
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        $polres_sudah_lapor =  PreemtifPmk::whereDate('created_at', $request->date)
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
