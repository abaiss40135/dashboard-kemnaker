<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\SupervisorPolmasExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\SupervisorPolmas\{StoreRequest, UpdateRequest};
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\{Sislap\Lapsubjar\Binpolmas\SupervisorPolmas, User};
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\SupervisorPolmasService;
use Illuminate\{Http\Request, Validation\ValidationException, Support\Arr, Support\Str};
use Maatwebsite\Excel\Excel;

class SupervisorPolmasController extends Controller
{
    private $model = SupervisorPolmas::class;

    protected $service;

    public function __construct()
    {
        $this->uploadPath   = 'binpolmas';
        $this->folderName   = 'supervisor-polmas';
        $this->service = new SupervisorPolmasService();
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.supervisor-polmas.index', [
            'columns' => $this->service->columns,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function create()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.supervisor-polmas.create');
    }

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
            ])->redirectTo(route('supervisor-polmas.index'));
        }

        try {
            foreach($data["laporan"] as $data) {
                $filename = $data['lampiran_file']->getClientOriginalName();
                $ext = Arr::last(explode('.', $filename));
                $this->fileName = now()->format('Y_m_d').'_'.str_replace($ext, ".$ext", Str::slug($filename));

                $data["lampiran_file"] = $this->saveFiles($data["lampiran_file"]);

                $laporan = SupervisorPolmas::query()
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
            }

            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $e) {
            $this->flashError($e->getMessage());
        }

        return redirect()->route('supervisor-polmas.index');
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
            'jumlah_supervisor_polres' => 'required|numeric',
            'jumlah_supervisor_polsek' => 'required|numeric',
            'lampiran_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        try {
            $ext = $data['lampiran_file']->getClientOriginalExtension();
            $filename = $data['lampiran_file']->getClientOriginalName();
            $ext = Arr::last(explode('.', $filename));
            $this->fileName = now()->format('Y_m_d').'_'.str_replace($ext, ".$ext", Str::slug($filename));

            $data['lampiran_file'] = $this->saveFiles($data['lampiran_file']);

            $laporan = SupervisorPolmas::query()
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
            return redirect()->route('supervisor-polmas.index');
        } catch (\Exception $e) {
            $this->flashError($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $laporan = SupervisorPolmas::findOrfail($id);

        try {
            if(isset($data['lampiran_file'])) {
                $this->deleteFiles($laporan->lampiran_file);

                $filename = $data['lampiran_file']->getClientOriginalName();
                $ext = Arr::last(explode('.', $filename));
                $this->fileName = now()->format('Y_m_d').'_'.str_replace($ext, ".$ext", Str::slug($filename));

                $data['lampiran_file'] = $this->saveFiles($data['lampiran_file']);
            }

            $laporan->update($data);

            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('supervisor-polmas.index');
    }

    public function destroy($id)
    {
        try {
            $data = SupervisorPolmas::find($id);

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

        return (new SupervisorPolmasExport(true))
            ->download('FORMAT LAPORAN DATA SUPERVISOR POLMAS '
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
        return view('administrator.sislap.lapsubjar.binpolmas.supervisor-polmas.index', [
            'laporan' => $data,
            'columns' => $this->service->columns,
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
        return (new SupervisorPolmasExport(false))
            ->download('EKSPOR LAPORAN SUPERVISOR POLMAS '
                .$additionalNotes
                .'.xlsx'
            );
    }

    public function search(Request $request)
    {
        $collection = $this->service->search($request);
        return response()->json($collection);
    }

    public function getListPolres(Request $request)
    {
        $kode_satuan = auth()->user()->personel->kode_satuan;
        $polda       = auth()->user()->personel->polda;
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        $polres_sudah_lapor =  SupervisorPolmas::whereDate('created_at', $request->date)
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
