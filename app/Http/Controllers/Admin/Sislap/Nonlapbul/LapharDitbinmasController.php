<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Exports\Sislap\Nonlapbul\LapharDitbinmasExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\LapharDitbinmas\StoreRequest;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\LapharDitbinmas\UpdateRequest;
use App\Models\Sislap\Nonlapbul\LapharDitbinmas;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\User;
use App\Services\Sislap\Nonlapbul\LapharDitbinmasService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;

class LapharDitbinmasController extends Controller
{
    protected $model = LapharDitbinmas::class;
    protected $service;

    public function __construct()
    {
        $this->service = new LapharDitbinmasService();
    }

    public function index()
    {
        return view('administrator.sislap.nonlapbul.laphar-ditbinmas.index', [
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
            ])->redirectTo(route('laphar-ditbinmas.index'));
        }

        $validated = $request->validated();
        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach ($validated['laporan'] as $item) {
                    $laporan = LapharDitbinmas::query()
                    ->whereDate('created_at', date('Y-m-d'))
                    ->updateOrCreate([
                        'polda' => $item['polda'],
                        'satker'=> $item['satker']
                    ], array_merge(Arr::except($item, ['polda', 'satker']), [
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
        return redirect()->route('laphar-ditbinmas.index');
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
            LapharDitbinmas::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('laphar-ditbinmas.index');
    }

    public function destroy($id)
    {
        try {
            LapharDitbinmas::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $collection = $this->service->search($request);
        return response()->json($collection);
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));
        return view('administrator.sislap.nonlapbul.laphar-ditbinmas.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function templateExcel()
    {
        $additionalName = '';
        if (auth()->user()->haveRoleID([User::BAGOPSNALEV_POLDA, User::BAGOPSNALEV_POLRES])) {
            $additionalName .= (' '.auth()->user()->personel->polda);
            if (auth()->user()->haveRoleID(User::BAGOPSNALEV_POLRES)) {
                $additionalName .= (' '.auth()->user()->personel->satker);
            }
        }

        return (new LapharDitbinmasExport(true))
            ->download('FORMAT LAPHAR RUTIN DITBINMAS'
                .$additionalName.' '
                .now()->format('Y-m-d')
                .'.xlsx'
            );
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
        return (new LapharDitbinmasExport(false))
            ->download('EKSPOR LAPHAR RUTIN DITBINMAS'
               .$additionalNotes
               .'.xlsx'
            );
    }
}
