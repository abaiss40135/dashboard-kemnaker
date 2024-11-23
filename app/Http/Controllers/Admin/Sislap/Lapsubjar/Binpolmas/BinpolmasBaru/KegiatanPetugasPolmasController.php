<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\{
    Exports\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmasExport as Export,
    Exports\Sislap\Lapsubjar\Binpolmas\TemplateLampiranKegiatanPetugasPolmasExport as LampiranExport,
    Http\Controllers\Controller,
    Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmas\StoreRequest,
    Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmas\UpdateRequest,
    Models\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmas as Model,
    Services\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmasService as Service,
    Imports\Sislap\ReadRows as ImportLaporan,
    Models\User,
};
use Illuminate\{
    Http\Request,
    Support\Arr,
    Support\Facades\DB,
    Support\Str,
    Validation\ValidationException,
};
use Maatwebsite\Excel\Excel;

class KegiatanPetugasPolmasController extends Controller
{
    protected string $model = Model::class;

    private Service $service;
    private string $view_path = 'administrator.sislap.lapsubjar.binpolmas.kegiatan-petugas-polmas';
    private string $heading = 'DATA KEGIATAN PETUGAS POLMAS';
    private string $today;

    public function __construct()
    {
        $this->service = new Service();
        $this->today = now()->format('Y_m_d');
        $this->uploadPath = 'lampiran';
        $this->folderName = 'lapsubjar_binpolmas_kegiatan_petugas_polmas';
    }

    public function index()
    {
        return view("{$this->view_path}.index", [
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function create()
    {
        return view("{$this->view_path}.create");
    }

    public function store(StoreRequest $request)
    {
        $user        = auth()->user()->load('personel');
        $levels      = explode('_', $user->role());
        $level       = end($levels);
        $personel    = $user->personel;
        $kode_satuan = $personel->kode_satuan;

        if (empty($kode_satuan)) throw ValidationException::withMessages([
            'kode_satuan' => 'Anda tidak memiliki satuan kerja'
        ])->redirectTo(route('kegiatan-petugas-polmas.index'));

        $validated = $request->validated();

        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach ($validated['data'] as $data) {
                    $filename = $data['lampiran']->getClientOriginalName();
                    $ext = Arr::last(explode('.', $filename));
                    $this->fileName = $this->today.'_'.str_replace($ext, ".$ext", Str::slug($filename));

                    $data['lampiran'] = $this->saveFiles($data['lampiran']);

                    $laporan = Model::query()
                        ->whereMonth('created_at', now()->format('m'))
                        ->updateOrCreate([
                            'polda' => $data['polda'],
                            'polres'=> $data['polres']
                        ], array_merge(
                            Arr::except($data, ['polda', 'polres']),
                            [
                                'user_id' => $user->id,
                                'kode_satuan' => $kode_satuan
                            ]
                        ));

                    if ($level === 'polda') $laporan->approvals()->create([
                        'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                        'level' => $level,
                    ]);
                }
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('kegiatan-petugas-polmas.index');
    }

    public function storeForm(Request $request)
    {
        $user = auth()->user()?->load('personel');
        $levels = explode('_', $user->role());
        $level = end($levels);
        $kode_satuan = $user->personel->kode_satuan;

        $data = $request->validate([
            'polda' => 'required',
            'polres' => 'required',
            'sambang' => 'required|numeric',
            'pemecahan_masalah' => 'required|numeric',
            'laporan_informasi' => 'required|numeric',
            'penanganan_perkara_ringan' => 'required|numeric',
            'lampiran' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        try {
            $ext = $data['lampiran']->getClientOriginalExtension();
            $filename = $data['lampiran']->getClientOriginalName();
            $ext = Arr::last(explode('.', $filename));
            $this->fileName = $this->today.'_'.str_replace($ext, ".$ext", Str::slug($filename));

            $data['lampiran'] = $this->saveFiles($data['lampiran']);

            $laporan = Model::query()
                ->create(array_merge($data, [
                    'user_id' => $user->id,
                    'kode_satuan' => $kode_satuan
                ]));

            if ($level === 'polda') {
                $laporan->approvals()->create([
                    'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                    'level' => $level,
                ]);
            }

            $this->flashSuccess('Berhasil menambahkan laporan');
            return redirect()->route('kegiatan-petugas-polmas.index');
        } catch (\Exception $e) {
            $this->flashError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $laporan = Model::find($id);

            if (isset($data['lampiran'])) {
                $this->deleteFiles($laporan->lampiran);
                $filename = $data['lampiran']->getClientOriginalName();
                $ext = Arr::last(explode('.', $filename));
                $this->fileName = $this->today.'_'.str_replace($ext, ".$ext", Str::slug($filename));

                $data['lampiran'] = $this->saveFiles($data['lampiran']);
            }

            $laporan->update($data);

            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('kegiatan-petugas-polmas.index');
    }

    public function destroy($id)
    {
        try {
            $data = Model::where('id', $id)->first();
            $this->deleteFiles($data->lampiran);
            $data->delete();

            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->back();
    }

    public function templateExcel()
    {
        $notes = '';

        if (roles([User::BINPOLMAS_POLDA, User::BINPOLMAS_POLRES])) {
            $personel = auth()->user()->personel;

            $notes .= ('_'.$personel->polda);

            if (roles([User::BINPOLMAS_POLRES])) $notes .= '_'.$personel->polres;
        }

        return (new Export(true))->download("FORMAT {$this->heading}{$notes} {$this->today}.xlsx");
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate(['file-laporan' => 'required|mimes:xlsx,xls']);

        $laporan = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));

        return view("{$this->view_path}.index", [
            'laporan' => $laporan,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel()
    {
        $notes = '';

        $request = request()->collect()
            ->filter(fn ($v, $k) => $k !== '_token' && !is_null($v))
            ->unique();

        if (count($request)) $notes .= '_'.implode('_', $request->toArray());

        return (new Export())->download("EKSPOR {$this->heading}{$notes}.xlsx");
    }

    public function search(Request $request)
    {
        $collection = $this->service->search($request);
        return response()->json($collection);
    }

    public function templateLampiran() {
        return (new LampiranExport())->download("TEMPLATE LAMPIRAN {$this->heading}.xlsx");
    }
}
