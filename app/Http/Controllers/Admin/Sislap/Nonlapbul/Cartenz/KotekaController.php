<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul\Cartenz;

use App\Exports\Sislap\Nonlapbul\OpsDamaiCartenzExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\StoreOpsDamaiCartenzRequest;
use App\Http\Requests\Administrator\Sislap\Nonlapbul\UpdateOpsDamaiCartenzRequest;
use App\Models\Sislap\Nonlapbul\OpsDamaiCartenz;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Sislap\Nonlapbul\OpsDamaiCartenzService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;

class KotekaController extends Controller
{
    protected $model = OpsDamaiCartenz::class;
    private $service;

    public function __construct()
    {
        $this->service = new OpsDamaiCartenzService(OpsDamaiCartenz::KOTEKA);
    }

    public function index()
    {
        return view('administrator.sislap.nonlapbul.ops-damai-cartenz.koteka', [
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreOpsDamaiCartenzRequest $request)
    {
        $user   = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level  = end($levels);
        $personel    = $user->personel;
        $kode_satuan = $personel->kode_satuan;

        if (empty($kode_satuan)) {
            throw ValidationException::withMessages([
                'kode_satuan' => 'Anda tidak memiliki satuan kerja'
            ])->redirectTo(route('cartenz.koteka.index'));
        }

        $validated = $request->validated();
        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach ($validated['laporan'] as $item) {
                    $laporan = OpsDamaiCartenz::query()
                    ->whereDate('created_at', date('Y-m-d'))
                    ->updateOrCreate(
                        [
                            'daops' => $item['daops'],
                            'type'  => OpsDamaiCartenz::KOTEKA,
                        ],
                        array_merge(Arr::except($item, ['daops']), [
                            'user_id'     => $user->id,
                            'kode_satuan' => $kode_satuan,
                        ]
                    ));

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

        return redirect()->route('cartenz.koteka.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(UpdateOpsDamaiCartenzRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            OpsDamaiCartenz::where('id', $id)->update($validated);
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('cartenz.koteka.index');
    }

    public function destroy($id)
    {
        try {
            OpsDamaiCartenz::where('id', $id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->back();
    }

    public function templateExcel()
    {
        $auth_user = auth()->user();
        $notes = match(true) {
            $auth_user->haveRoleID([User::BAGOPSNALEV_POLDA])  => ' '.$auth_user->personel->polda,
            $auth_user->haveRoleID([User::BAGOPSNALEV_POLRES]) => ' '.$auth_user->personel->polres,
            default => ''
        };

        return (new OpsDamaiCartenzExport(OpsDamaiCartenz::KOTEKA, true))
                ->download("FORMAT LAPHAR KOTEKA $notes ".now()->format("Y-m-d").".xlsx");
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));
        return view('administrator.sislap.nonlapbul.ops-damai-cartenz.koteka', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel()
    {
        $req = request()->collect()->filter(fn ($i, $k) => $k !== '_token' && !is_null($i))->unique();
        $notes = !count($req) ? '' : ' ' . implode(' ', $req->toArray());

        return (new OpsDamaiCartenzExport(OpsDamaiCartenz::KOTEKA))
            ->download('EKSPOR LAPHAR KOTEKA '.$notes.'.xlsx');
    }

    public function search(Request $request)
    {
        return response()->json($this->service->search($request));
    }

    public function getListPolres(Request $request)
    {
        $kode_satuan = auth()->user()->personel->kode_satuan;
        $polda       = auth()->user()->personel->polda;
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        $polres_sudah_lapor = OpsDamaiCartenz::whereDate('created_at', $request->date)
                              ->where('polda', $polda)
                              ->pluck('id', 'polres')
                              ->toArray();

        $status_lapor = [];
        $can_send_approval = true;

        foreach($polres_list as $item) {
            $status = Collect(array_keys($polres_sudah_lapor))->contains($item['nama_satuan']);
            $status_lapor[] = [
                'nama_satuan' => $item['nama_satuan'],
                'status'      => $status,
            ];
            $can_send_approval = $can_send_approval && $status;
        };

        return response()->json([
            'status_lapor'      => $status_lapor,
            'can_send_approval' => $can_send_approval,
            'laporan_ids'       => Collect(array_values($polres_sudah_lapor))
        ]);
    }
}
