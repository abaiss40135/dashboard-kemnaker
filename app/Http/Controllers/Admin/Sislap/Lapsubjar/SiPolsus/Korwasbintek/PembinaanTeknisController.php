<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\SiPolsus\Korwasbintek;

use App\Exports\Sislap\Lapsubjar\Sipolsus\Korwasbintek\PembinaanTeknisExport as TemplateLaporan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Sipolsus\Korwasbintek\PembinaanTeknis\StoreRequest;
use App\Http\Requests\Administrator\Sislap\Sipolsus\Korwasbintek\PembinaanTeknis\UpdateRequest;
use App\Models\Sislap\Lapsubjar\Sipolsus\Korwasbintek\PembinaanTeknis;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\User;
use App\Services\Sislap\Sipolsus\Korwasbintek\PembinaanTeknisService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;

class PembinaanTeknisController extends Controller
{
    protected $model = PembinaanTeknis::class;
    protected $service;

    public function __construct()
    {
        $this->service = new PembinaanTeknisService();
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.si-polsus.korwasbintek.pembinaan-teknis.index', [
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
            ])->redirectTo(route('korwasbintek.pembinaan-teknis.index'));
        }

        $validated = $request->validated();
        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach ($validated['laporan'] as $item) {
                    $laporan = PembinaanTeknis::query()
                        ->whereDate('created_at', date('Y-m-d'))
                        ->create(array_merge($item, [
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
        return redirect()->route('korwasbintek.pembinaan-teknis.index');
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
            PembinaanTeknis::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('korwasbintek.pembinaan-teknis.index');
    }

    public function destroy($id)
    {
        try {
            PembinaanTeknis::where('id', $id)->delete();
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
        return view('administrator.sislap.lapsubjar.si-polsus.korwasbintek.pembinaan-teknis.index', [
            'laporan' => $data,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function templateExcel()
    {
        $polda = '';
        if (auth()->user()->haveRoleID([User::BAGOPSNALEV_POLDA, User::OPERATOR_POLSUS_POLDA])) {
            $polda = auth()->user()->personel->polda;
        }

        return (new Templatelaporan(true))
            ->download(
                'FORMAT LAPHAR RUTIN KORWASBINTEK PEMBINAAN TEKNIS'
                    . " $polda "
                    . now()->format('Y-m-d')
                    . '.xlsx'
            );
    }

    public function exportExcel()
    {
        $additionalNotes = '';
        $request = request()->collect()->filter(fn ($item, $key) => $key !== '_token' && !is_null($item))->unique();

        if (count($request)) {
            $additionalNotes .= ' ' . implode(' ', $request->toArray());
        }
        return (new Templatelaporan(false))
            ->download(
                'EKSPOR LAPHAR RUTIN KORWASBINTEK PEMBINAAN TEKNIS'
                    . $additionalNotes
                    . '.xlsx'
            );
    }
}
