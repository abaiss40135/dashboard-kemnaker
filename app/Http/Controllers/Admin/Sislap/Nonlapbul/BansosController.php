<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Exports\Sislap\Nonlapbul\BansosExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\StoreBansosRequest;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\UpdateBansosRequest;
use App\Models\Sislap\Nonlapbul\Bansos;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\User;
use App\Services\Sislap\Nonlapbul\BansosService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;
use App\Models\Dokumentasi;

class BansosController extends Controller
{
    protected $model = Bansos::class;
    private $bansosService;

    public function __construct()
    {
        $this->bansosService = new BansosService();
    }

    public function index()
    {
        return view('administrator.sislap.nonlapbul.bansos', [
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreBansosRequest $request)
    {
        $user = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level = end($levels);
        $personel = $user->personel;
        $kode_satuan = $personel->kode_satuan;

        $this->uploadPath   = 'dokumentasi';
        $this->folderName   = 'laphar_bansos';
        /**
         * Handling apabila user tidak memiliki personel dan kode satuan
         */
        if (empty($kode_satuan)) {
            throw ValidationException::withMessages([
                'kode_satuan' => 'Anda tidak memiliki satuan kerja'
            ])->redirectTo(route('bansos.index'));
        }
        $validated = $request->validated();
        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach ($validated['laporan'] as $item) {
                    $dokumentasis = Arr::pull($item, 'dokumentasi');
                    $laporan = Bansos::query()
                        ->whereDate('created_at', date('Y-m-d'))
                        ->updateOrCreate([
                            'polda' => $item['polda'],
                            'polres'=> $item['polres']
                        ], array_merge(Arr::except($item, ['polda', 'polres']), [
                            'user_id' => $user->id,
                            'kode_satuan' => $kode_satuan
                        ])
                    );

                    if ($laporan->dokumentasi) {
                        foreach($laporan->dokumentasi as $dokumentasi) {
                            $this->deleteFiles($dokumentasi->file);
                            $dokumentasi->delete();
                        }
                    }

                    foreach($dokumentasis as $dokumentasi) {
                        $this->fileName = Str::slug($dokumentasi->getClientOriginalName()).now()->format('Y_m_d').'.'.$dokumentasi->getClientOriginalExtension();
                        Dokumentasi::create([
                            'laporan_type' => $this->model,
                            'laporan_id' => $laporan->id,
                            'file' => $this->saveFiles($dokumentasi)
                        ]);
                    }

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
        return redirect()->route('bansos.index');
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
        $this->uploadPath   = 'dokumentasi';
        $this->folderName   = 'laphar_bansos';

        $validated = $request->all();
        try {
            $laporan = Bansos::find($id);
            $laporan->update(Arr::except($validated, 'dokumentasi'));

            $dokumentasis = Arr::pull($validated, 'dokumentasi');
//            jika user upload gambar
            if($dokumentasis) {
                if ($laporan->dokumentasi) {
                    foreach($laporan->dokumentasi as $dokumentasi) {
                        $this->deleteFiles($dokumentasi->file);
                        $dokumentasi->delete();
                    }
                }

                foreach($dokumentasis as $dokumentasi) {
                    $this->fileName = Str::slug($dokumentasi->getClientOriginalName()).now()->format('Y_m_d').'.'.$dokumentasi->getClientOriginalExtension();
                    Dokumentasi::create([
                        'laporan_type' => $this->model,
                        'laporan_id' => $laporan->id,
                        'file' => $this->saveFiles($dokumentasi)
                    ]);
                }
            }

            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('bansos.index');
    }

    public function destroy($id)
    {
        try {
            $bansos = Bansos::where('id', $id)->first();
            foreach($bansos->dokumentasi as $dokumentasi) {
                $this->deleteFiles($dokumentasi->file);
                $dokumentasi->delete();
            }
            $bansos->delete();

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

        return (new BansosExport(true))->download('FORMAT LAPHAR BANSOS'.$additionalName.' '.now()->format('Y-m-d').'.xlsx');
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));
        return view('administrator.sislap.nonlapbul.bansos', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel()
    {
        $additionalNotes = '';

        $request = request()->collect()
            ->filter(fn ($v, $k) => $k !== '_token' && !is_null($v))
            ->unique();

        if (count($request)) {
            $additionalNotes .= ' '.implode(' ', $request->toArray());
        }

        return (new BansosExport())
            ->download('EKSPOR LAPHAR BANSOS '.$additionalNotes.'.xlsx');
    }

    public function search(Request $request)
    {
        $collection = $this->bansosService->search($request);
        return response()->json($collection);
    }
}