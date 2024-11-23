<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Exports\Sislap\Nonlapbul\PenyakitMulutKukuExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\StorePMKRequest;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\UpdatePMKRequest;
use App\Models\Sislap\Nonlapbul\PenyakitMulutKuku;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Sislap\Nonlapbul\PenyakitMulutKukuService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;

class PenyakitMulutKukuController extends Controller
{
    protected $model = PenyakitMulutKuku::class;

    private $penyakitMulutKukuService;

    public function __construct()
    {
        $this->penyakitMulutKukuService = new PenyakitMulutKukuService();
    }

    public function index()
    {
        return view('administrator.sislap.nonlapbul.pmk.monitoring', [
            'kategori' => $this->penyakitMulutKukuService->kategori,
            'tipe' => $this->penyakitMulutKukuService->tipe,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StorePMKRequest $request)
    {
        $user = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level = end($levels);

        $personel = $user->personel;
        $kode_satuan = $personel->kode_satuan;
        /**
         * Handling apabila user tidak memiliki personel dan kode satuan
         */
        if (empty($kode_satuan)) {
            throw ValidationException::withMessages([
                'kode_satuan' => 'Anda tidak memiliki satuan kerja'
            ])->redirectTo(route('penyakit-mulut-kuku.index'));
        }
        $validated = $request->validated();
        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach ($validated['laporan'] as $item) {
                    $laporan = PenyakitMulutKuku::query()
                    ->whereDate('created_at', date('Y-m-d'))
                    ->updateOrCreate([
                        'polda' => $item['polda'],
                        'polres'=> $item['polres']
                    ],array_merge(Arr::except($item, ['polda', 'polres']), [
                        'user_id' => $user->id,
                        'kode_satuan' => $kode_satuan
                    ]));

                    /*$laporan = PenyakitMulutKuku::create(array_merge($item, [
                        'user_id' => $user->id,
                        'kode_satuan' => $kode_satuan
                    ]));*/
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
        return redirect()->route('penyakit-mulut-kuku.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(UpdatePMKRequest $request, $id)
    {
        $validated = $request->validated();
        try {
            PenyakitMulutKuku::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('penyakit-mulut-kuku.index');
    }

    public function destroy($id)
    {
        try {
            PenyakitMulutKuku::where('id', $id)->delete();
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
            $additionalName .= (' ' . auth()->user()->personel->polda);
            if (auth()->user()->haveRoleID(User::BAGOPSNALEV_POLRES)) {
                $additionalName .= (' ' . auth()->user()->personel->polres);
            }
        }

        return (new PenyakitMulutKukuExport(true))->download('FORMAT LAPHAR PMK' . $additionalName . ' ' . now()->format('Y-m-d') . '.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));
        return view('administrator.sislap.nonlapbul.pmk.monitoring', [
            'laporan' => $data,
            'kategori' => $this->penyakitMulutKukuService->kategori,
            'tipe' => $this->penyakitMulutKukuService->tipe,
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
            $additionalNotes .= ' ' . implode(' ', $request->toArray());
        }
        return (new PenyakitMulutKukuExport())
            ->download('EKSPOR LAPHAR PMK '
                . $additionalNotes
                . '.xlsx'
            );
    }

    public function search(Request $request)
    {
        $collection = $this->penyakitMulutKukuService->search($request);
        return response()->json(collect(['sums' => $this->penyakitMulutKukuService->sumExport($collection)])->merge($collection));
    }

    public function getListPolres(Request $request)
    {
        $kode_satuan = auth()->user()->personel->kode_satuan;
        $polda       = auth()->user()->personel->polda;
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        $polres_sudah_lapor =  PenyakitMulutKuku::whereDate('created_at', $request->date)
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
