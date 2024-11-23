<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\{
    Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataKomunitasMasyarakatExport,
    Http\Controllers\Controller,
    Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas\DataKomunitasMasyarakat\StoreRequest,
    Http\Requests\Administrator\Sislap\Lapsubjar\Binpolmas\DataKomunitasMasyarakat\UpdateRequest,
    Models\Sislap\Lapsubjar\Binpolmas\DataKomunitasMasyarakat,
    Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataKomunitasMasyarakatService,
    Imports\Sislap\ReadRows as ImportLaporan
};
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\{
    Http\Request,
    Support\Arr,
    Support\Facades\DB,
    Validation\ValidationException
};
use Maatwebsite\Excel\Excel;

class DataKomunitasMasyarakatController extends Controller
{
    protected $model = DataKomunitasMasyarakat::class;
    private $dataKomunitasMasyarakatService;

    public function __construct()
    {
        $this->dataKomunitasMasyarakatService = new DataKomunitasMasyarakatService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.data-komunitas-masyarakat.index', [
            'columns' => $this->dataKomunitasMasyarakatService->columns,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.data-komunitas-masyarakat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $user = auth()->user()->load('personel');
        $levels = explode('_', $user->role());
        $level = end($levels);
        $kode_satuan = $user->personel->kode_satuan;

        if (empty($kode_satuan)) throw ValidationException::withMessages([
            'kode_satuan' => 'Anda tidak memiliki satuan kerja'
        ]);

        $validatedRequest = $request->validated();

        try {
            $transactionKommas = DB::transaction(function () use ($validatedRequest, $user, $level, $kode_satuan) {
                if (array_key_exists("data", $validatedRequest)) {
                    foreach ($validatedRequest['data'] as $item) {
                        $item['alamat'] = $this->dataKomunitasMasyarakatService->getAlamat($item);

                        $item = Arr::except($item, ['_token', 'provinsi', 'kabupaten', 'kecamatan', 'desa']);

                        $laporan = DataKomunitasMasyarakat::create(
                            array_merge($item, [
                                'user_id' => $user->id,
                                'kode_satuan' => $kode_satuan,
                            ])
                        );

                        if ($level === 'polda') $laporan->approvals()->create([
                            'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level' => $level,
                        ]);
                    }
                    return 'store';
                } else {
                    foreach ($validatedRequest['laporan'] as $item) {

                        $item['alamat'] = $this->dataKomunitasMasyarakatService->getAlamat($item);
                        $item["provinsi_code"] = Provinsi::firstWhere('name', 'ilike', '%' . $item["provinsi"] . '%')?->code;
                        $item["kabupaten_code"] = Kota::firstWhere('name', 'ilike', '%' . $item["kabupaten"] . '%')?->code;
                        $item["kecamatan_code"] = Kecamatan::firstWhere('name', 'ilike', '%' . $item["kecamatan"] . '%')?->code;
                        $item["desa_code"] = Desa::firstWhere('name', 'ilike', '%' . $item["desa"] . '%')?->code;

                        $item = Arr::except($item, ['_token', 'provinsi', 'kabupaten', 'kecamatan', 'desa']);

                        $laporan = DataKomunitasMasyarakat::create(
                            array_merge($item, [
                                'user_id' => $user->id,
                                'kode_satuan' => $kode_satuan,
                            ])
                        );

                        if ($level === 'polda') $laporan->approvals()->create([
                            'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                            'level' => $level,
                        ]);
                    }
                    return 'import';
                }
            });

            if($transactionKommas === 'store') {
                return $this->responseSuccess([
                    'message' => 'Berhasil menambahkan laporan'
                ]);
            }

            $this->flashSuccess("Berhasil menambahkan laporan");
            return redirect()->route("data-komunitas-masyarakat.index");
        } catch (\Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $data['alamat'] = $this->dataKomunitasMasyarakatService->getAlamat($data);
            Arr::except($data, ['provinsi', 'kabupaten', 'kecamatan', 'desa']);

            DataKomunitasMasyarakat::find($id)->update($data);

            return $this->responseSuccess([
                'message' => 'Berhasil menambahkan laporan'
            ]);
        } catch (\Exception $exception) {
            return $this->responseError($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DataKomunitasMasyarakat::find($id)->delete();
            $this->flashSuccess('Laporan berhasil dihapus');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->back();
    }

    public function templateExcel()
    {
        $additionalName = '';
        if (auth()->user()->haveRoleID([User::BINPOLMAS_POLDA, User::BINPOLMAS_POLRES_POLRES])) {
            $additionalName .= (' ' . auth()->user()->personel->polda);
            if (auth()->user()->haveRoleID(User::BINPOLMAS_POLRES)) {
                $additionalName .= (' ' . auth()->user()->personel->polres);
            }
        }

        return (new DataKomunitasMasyarakatExport(true))
            ->download(
                'FORMAT LAPORAN DATA KOMUNITAS MASYARAKAT BINAAN POLRI '
                    . $additionalName . ' '
                    . now()->format('Y-m-d')
                    . '.xlsx'
            );
    }
    public function importExcel(Request $request, Excel $excel)
    {
        $request->validate([
            'file-laporan' => ['required']
        ]);

        $data = $excel->toArray(new ImportLaporan, $request->file('file-laporan'));
        return view('administrator.sislap.lapsubjar.binpolmas.data-komunitas-masyarakat.index', [
            'laporan' => $data,
            'columns' => $this->dataKomunitasMasyarakatService->columns,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function exportExcel()
    {
        $additionalNotes = '';
        $request = request()->collect()->filter(
            fn ($v, $k) =>
            $k !== '_token' && !is_null($v)
        )->unique();

        if (count($request)) {
            $additionalNotes .= ' ' . implode(' ', $request->toArray());
        }

        return (new DataKomunitasMasyarakatExport())
            ->download(
                'EKSPOR LAPORAN DATA KOMUNITAS MASYARAKAT'
                    . $additionalNotes
                    . '.xlsx'
            );
    }

    public function search(Request $request)
    {
        $collection = $this->dataKomunitasMasyarakatService->search($request);

        return response()->json($collection);
    }

    public function errorDate($inputType)
    {
        request()->session()->flash('swal_msg', [
            'title' => "Format Tanggal {$inputType} kurang benar",
            'message' => 'Pastikan format tanggal yang dicantumkan pada Excel adalah Tanggal/Bulan/Tahun, contoh : (07/11/2023)',
            'type' => 'warning',
        ]);

        return redirect()->route('data-komunitas-masyarakat.index');
    }
}
