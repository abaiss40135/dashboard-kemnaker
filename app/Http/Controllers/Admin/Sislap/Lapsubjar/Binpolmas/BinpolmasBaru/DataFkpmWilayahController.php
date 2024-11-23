<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataFkpmWilayahExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Lapsubjar\BinpolmasBaru\DataFkpmWilayah\StoreRequest;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Jobs\BulkStoreDataBinpolmas;
use App\Models\Sislap\Lapsubjar\Binpolmas\DataFkpm;
use App\Models\User;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataFkpmWilayahService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;

class DataFkpmWilayahController extends Controller
{
    protected $model = DataFkpm::class;

    private $DataFkpmWilayahService;

    public function __construct()
    {
        $this->DataFkpmWilayahService = new DataFkpmWilayahService();
    }

    public function index()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.data-fkpm-wilayah.index', [
            'columns' => $this->DataFkpmWilayahService->columns,
            'model' => addcslashes($this->model, "\\")
        ]);
    }

    public function create()
    {
        return view('administrator.sislap.lapsubjar.binpolmas.data-fkpm-wilayah.create');
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
            ])->redirectTo(route('data-fkpm-wilayah.index'));
        }

        $validated = $request->validated();
        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                if(array_key_exists( "laporan", $validated)) {
                    foreach ($validated['laporan'] as $item) {
                        $laporan = DataFkpm::create(array_merge($item, [
                            'user_id' => $user->id,
                            'kode_satuan' => $kode_satuan,
                            'type' => 'wilayah'
                        ]));

                        if ($level === 'polda') {
                            $laporan->approvals()->create([
                                'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                                'level' => $level,
                            ]);
                        }
                    }
                    $this->flashSuccess('Berhasil menambahkan laporan');
                } else {
                    foreach ($validated['data'] as $item) {
                        $laporan = DataFkpm::create(array_merge($item, [
                            'user_id' => $user->id,
                            'kode_satuan' => $kode_satuan,
                            'type' => 'wilayah'
                        ]));

                        if ($level === 'polda') {
                            $laporan->approvals()->create([
                                'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                                'level' => $level,
                            ]);
                        }
                    }
                }
            });
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-fkpm-wilayah.index');
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
        $validated = $request->all();
        try {
            DataFkpm::find($id)->update($validated);
            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }
        return redirect()->route('data-fkpm-wilayah.index');
    }

    public function destroy($id)
    {
        try {
            DataFkpm::where('id', $id)->delete();
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

        return (new DataFkpmWilayahExport(true))
            ->download('FORMAT LAPORAN DATA FKPM WILAYAH'
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

        if(count($data[0]) > 50) {
            $chunkData = array_chunk($data[0], 50);
            foreach ($chunkData as $index => $chunk) {
                if($index == 0) {
                    $chunk = array_slice($chunk, 2);
                }

                $laporan = [
                    'laporan' => array_map(function ($item) {
                        return [
                            "polda" => $item[1],
                            "polres" => $item[2],
                            "nama_fkpm" => $item[3],
                            "nama_petugas_polmas" => $item[4],
                            "pangkat_petugas_polmas" => $item[5],
                            "no_hp_petugas_polmas" => $item[6],
                            "jumlah_anggota_fkpm" => $item[7],
                            "wilayah" => $item[8],
                            "bkpm" => $item[9],
                            "rw" => $item[10],
                            "dusun" => $item[11],
                            "desa_kel" => $item[12],
                            "kecamatan" => $item[13],
                            "kab_kota" => $item[14],
                            "provinsi" => $item[15],
                            "keterangan" => $item[16],
                        ];
                    }, $chunk)
                ];

                $user = auth()->user()->load('personel');
                $levels = explode('_', $user->role());
                $level = end($levels);
                $kode_satuan = $user->personel->kode_satuan;

                BulkStoreDataBinpolmas::dispatch($laporan, $user, $levels, $level, $kode_satuan, DataFkpm::class, 'wilayah');
            }

            $this->flashSuccess('Sistem sedang memproses laporan yang diupload, silahkan cek kembali dalam beberapa saat');
            return redirect()->route('data-fkpm-wilayah.index');
        }

        return view('administrator.sislap.lapsubjar.binpolmas.data-fkpm-wilayah.index', [
            'laporan' => $data,
            'columns' => $this->DataFkpmWilayahService->columns,
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
        return (new DataFkpmWilayahExport())
            ->download('Laporan Data FKPM Wilayah '
               .$additionalNotes
               .'.xlsx'
            );
    }

    public function search(Request $request)
    {
        $collection = $this->DataFkpmWilayahService->search($request);
        return response()->json($collection);
    }

    public function getListPolres(Request $request)
    {
        $kode_satuan = auth()->user()->personel->kode_satuan;
        $polda       = auth()->user()->personel->polda;
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        $polres_sudah_lapor =  DataFkpm::whereDate('created_at', $request->date)
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
