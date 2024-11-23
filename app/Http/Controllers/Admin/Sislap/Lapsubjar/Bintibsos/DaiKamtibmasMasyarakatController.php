<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\Bintibsos;

use App\Exports\Sislap\Lapsubjar\Bintibsos\DaiKamtibmasExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\Sislap\Lapsubjar\Bintibsos\UpdateDaiKamtibmasMasyarakatRequest;
use App\Imports\Sislap\ReadRows as ImportLaporan;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\Sislap\Lapsubjar\Bintibsos\DaiKamtibmas;
use App\Models\User;
use App\Services\Sislap\Lapsubjar\Bintibsos\DaiKamtibmasMasyarakatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Excel;

class DaiKamtibmasMasyarakatController extends Controller
{
    private $model = DaiKamtibmas::class;

    protected $daiKamtibmasMasyarakatService;

    public function __construct()
    {
        $this->daiKamtibmasMasyarakatService = new DaiKamtibmasMasyarakatService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrator.sislap.lapsubjar.bintibsos.dai-kamtibmas.masyarakat.index', [
            'columns' => $this->daiKamtibmasMasyarakatService->columns,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            ])->redirectTo(route('dai-kamtibmas-masyarakat.index'));
        }

        $validated = $request->all();
        try {
            DB::transaction(function () use ($level, $user, $validated, $kode_satuan) {
                foreach ($validated['laporan'] as $item) {
                    if(preg_match('/^[0-9]+$/', $item["provinsi"]) === 1) {
                        $item["provinsi"] = Provinsi::where('code', $item["provinsi"])->pluck('name')->first();
                    }

                    if(preg_match('/^[0-9]+$/', $item["kabupaten"]) === 1) {
                        $item["kabupaten"] = Kota::where('code', $item["kabupaten"])->pluck('name')->first();
                    }

                    if(preg_match('/^[0-9]+$/', $item["kecamatan"]) === 1) {
                        $item["kecamatan"] = Kecamatan::where('code', $item["kecamatan"])->pluck('name')->first();
                    }

                    if(preg_match('/^[0-9]+$/', $item["kelurahan"]) === 1) {
                        $item["kelurahan"] = Desa::where('code', $item["kelurahan"])->pluck('name')->first();
                    }

                    $laporan = DaiKamtibmas::query()
                        ->create(array_merge($item, [
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
        return redirect()->route('dai-kamtibmas-masyarakat.index');
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
    public function update(UpdateDaiKamtibmasMasyarakatRequest $request, $id)
    {
        $validated = $request->validated();
        try {
            DaiKamtibmas::find($id)->update($validated);

            if(preg_match('/^[0-9]+$/', $validated["provinsi"]) === 1) {
                $validated["provinsi"] = Provinsi::where('code', $validated["provinsi"])->pluck('name')->first();
            }

            if(preg_match('/^[0-9]+$/', $validated["kabupaten"]) === 1) {
                $validated["kabupaten"] = Kota::where('code', $validated["kabupaten"])->pluck('name')->first();
            }

            if(preg_match('/^[0-9]+$/', $validated["kecamatan"]) === 1) {
                $validated["kecamatan"] = Kecamatan::where('code', $validated["kecamatan"])->pluck('name')->first();
            }

            if(preg_match('/^[0-9]+$/', $validated["kelurahan"]) === 1) {
                $validated["kelurahan"] = Desa::where('code', $validated["kelurahan"])->pluck('name')->first();
            }

            $this->flashSuccess('laporan berhasil diperbarui');
        } catch (\Exception $exception) {
            $this->flashError($exception->getMessage());
        }

        return redirect()->route('dai-kamtibmas-masyarakat.index');
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
            DaiKamtibmas::find($id)->delete();
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

        return (new DaiKamtibmasExport(true, 'masyarakat'))
            ->download('FORMAT LAPORAN DATA DA\'I KAMTIBMAS (MASYARAKAT) '
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
        return view('administrator.sislap.lapsubjar.bintibsos.dai-kamtibmas.masyarakat.index', [
            'laporan' => $data,
            'columns' => $this->daiKamtibmasMasyarakatService->columns,
            'addressColumn' => $this->daiKamtibmasMasyarakatService->addressColumn,
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
        return (new DaiKamtibmasExport(false,'masyarakat'))
            ->download('EKSPOR LAPORAN DATA DA\'I KAMTIBMAS (MASYARAKAT)  '
                .$additionalNotes
                .'.xlsx'
            );
    }

    public function search(Request $request)
    {
        $collection = $this->daiKamtibmasMasyarakatService->search($request);
        return response()->json($collection);
    }

    public function getListPolres(Request $request)
    {
        $kode_satuan = auth()->user()->personel->kode_satuan;
        $polda       = auth()->user()->personel->polda;
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        $polres_sudah_lapor =  DaiKamtibmas::whereDate('created_at', $request->date)
            ->where('polda', $polda)->pluck('id', 'polres')->where("tipe", "berbadan_hukum")->toArray();

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

    public function errorDate($inputType)
    {
        request()->session()->flash('swal_msg', [
            'title' => "Format {$inputType} kurang benar",
            'message' => 'Pastikan format tanggal yang dicantumkan pada Excel adalah Tanggal/Bulan/Tahun, contoh : (07/11/2023)',
            'type' => 'warning',
        ]);

        return redirect()->route('dai-kamtibmas-masyarakat.index');
    }
}
