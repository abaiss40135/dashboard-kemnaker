<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binkamsa;

use App\Exports\Sislap\Lapsubjar\Binkamsa\MasterDataSatpamBelumDikExport;
use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Lapsubjar\Binkamsa\MasterDataSatpamBelumDik\StoreRequest;
use App\Http\Requests\Administrator\Sislap\Lapsubjar\Binkamsa\MasterDataSatpamBelumDik\UpdateRequest;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Sislap\Lapsubjar\Binkamsa\MasterDataSatpamBelumDik;
use App\Models\User;
use App\Services\Sislap\Lapsubjar\Binkamsa\MasterDataSatpamBelumDikService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;

class MasterDataSatpamBelumDikController extends Controller
{
    protected $model = MasterDataSatpamBelumDik::class;
    protected $service;

    public function __construct()
    {
        $this->service = new MasterDataSatpamBelumDikService();
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.binkamsa.master-data-satpam-belum-dik', [
            'model' => addcslashes($this->model, '\\'),
        ]);
    }

    public function create()
    {
    }

    public function store(StoreRequest $request)
    {
        $user = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level = end($levels);
        $kode_satuan = $user->personel->kode_satuan;

        /*
         * Handle user tidak memiliki personel dan kode satuan
         */
        if (empty($kode_satuan)) {
            throw ValidationException::withMessages(['kode_satuan' => 'Anda tidak memiliki satuan kerja'])->redirectTo(route('master-data-satpam-belum-dik.index'));
        }

        $validated = $request->validated();
        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach ($validated['laporan'] as $item) {
                    $laporan = MasterDataSatpamBelumDik::query()->create(array_merge($item, [
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
            });
            $this->flashSuccess('Berhasil menambahkan laporan');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('master-data-satpam-belum-dik.index');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        try {
            MasterDataSatpamBelumDik::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('master-data-satpam-belum-dik.index');
    }

    public function destroy($id)
    {
        try {
            MasterDataSatpamBelumDik::where('id', $id)->delete();
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

    public function count(Request $request)
    {
        $result = $this->service->count($request);

        return response()->json($result);
    }

    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required', 'mimes:xlsx,xls'],
        ]);

        $data = $excel->toArray(new ImportLaporan(), $request->file('file-laporan'));

        return view('administrator.sislap.lapsubjar.binkamsa.master-data-satpam-belum-dik', [
            'laporan' => $data,
            'model' => addcslashes($this->model, '\\'),
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

        return (new MasterDataSatpamBelumDikExport(true))
            ->download('FORMAT LAPSUBJAR MASTER DATA SATPAM BELUM DIKLAT'
                .$additionalName.' '
                .now()->format('Y-m-d')
                .'.xlsx'
            );
    }

    public function exportExcel()
    {
        $additionalNotes = '';
        $request = request()->collect()->filter(function ($item, $key) {
            return $key !== '_token' && !is_null($item);
        })->unique();
        if (count($request)) {
            $additionalNotes .= ' '.implode(' ', $request->toArray());
        }

        return (new MasterDataSatpamBelumDikExport(false))
            ->download('EKSPOR LAPSUBJAR MASTER DATA SATPAM BELUM DIKLAT'
               .$additionalNotes
               .'.xlsx'
            );
    }

    public function chart()
    {
        $data = MasterDataSatpamBelumDik::leftJoin('personel', 'personel.user_id', '=', 'sislap_master_data_satpam.user_id')
            ->select('satuan1', DB::raw('count(sislap_master_data_satpam.id) as jumlah'))
            ->groupBy('satuan1')
            ->pluck('jumlah', 'satuan1')
            ->toArray();

        $sortedData = [];

        foreach ($data as $realKey => $value) {
            $removedCodeKey = explode('-', $realKey)[0];
            $cleanedKey = str_replace('POLDA ', '', $removedCodeKey);
            $newKey = Constants::MAP_PATH[$cleanedKey];

            if ($newKey) {
                $newKey = str_replace('path', '', $newKey);
                $sortedData[$newKey] = "$removedCodeKey;$value";
            }
        }

        ksort($sortedData);

        $finalData = [];

        foreach ($sortedData as $value) {
            $value = explode(';', $value);
            $finalData[] = [
                'satuan' => $value[0],
                'jumlah' => $value[1],
            ];
        }

        return response()->json($finalData);
    }
}
