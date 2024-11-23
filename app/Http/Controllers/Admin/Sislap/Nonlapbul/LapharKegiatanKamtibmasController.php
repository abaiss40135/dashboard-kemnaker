<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul;

use App\Exports\Sislap\Nonlapbul\LapharKegiatanKamtibmasExport;
use App\Http\Controllers\Controller;
use App\Models\Sislap\Nonlapbul\KegiatanCegahTindakPidanaKamtibmas\LapharKegiatanKamtibmas;
use App\Models\Sislap\Nonlapbul\KegiatanCegahTindakPidanaKamtibmas\ListKegiatan;
use App\Models\User;
use App\Services\Sislap\Nonlapbul\LapharKegiatanKamtibmasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LapharKegiatanKamtibmasController extends Controller
{
    protected $model = LapharKegiatanKamtibmas::class;
    protected $service;

    public function __construct()
    {
        $this->service = new LapharKegiatanKamtibmasService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrator.sislap.nonlapbul.laphar-kegiatan-kamtibmas.index', [
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
        $kegiatans = ListKegiatan::query()->pluck('nama', 'id');
        return view('administrator.sislap.nonlapbul.laphar-kegiatan-kamtibmas.create', [
            'kegiatans' => $kegiatans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan' => ['required', 'array']
        ]);

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
            ])->redirectTo(route('laphar-kegiatan-kamtibmas.index'));
        }

        $input = $request->get('kegiatan');
        if(count($input) < ListKegiatan::count()){
            throw ValidationException::withMessages(['kegiatan' => 'Seluruh kegiatan harus diisi!']);
        }
        $inputKegiatan = collect($input)->flatten();
        if($inputKegiatan->filter(fn ($item, $key) => !is_numeric($item))->count() > 0){
            throw ValidationException::withMessages(['kegiatan' => 'Isian jumlah kegiatan harus berupa angka!']);
        }

        DB::beginTransaction();
        try {
            $laporan = LapharKegiatanKamtibmas::query()
                            ->whereDate('created_at', date('Y-m-d'))
                            ->updateOrCreate([
                                'user_id'       => $user->id,
                                'polda'         => $user->personel->polda,
                                'polres'        => $request->get('polres', $user->personel->polres)
                            ], [
                                'total_kegiatan'=> $inputKegiatan->sum(),
                                'kode_satuan'   => $kode_satuan
                            ]);
            $laporan->kegiatans()->sync($input);

            if ($level === 'polda') {
                $laporan->approvals()->create([
                    'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                    'level' => $level,
                ]);
            }
            DB::commit();
            $this->flashSuccess('Laporan berhasil ditambahkan');
            return redirect()->route('laphar-kegiatan-kamtibmas.index');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->flashError('Laporan Gagal Ditambahkan: ' + $e->getMessage());
            return redirect()->back()->withInput($request->all());
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
        $laporan = LapharKegiatanKamtibmas::with('approvals', 'kegiatans')->find($id);
        if (request()->ajax()) {
            return response()->json([
                'data' => $laporan
            ], 200);
        }
        return $laporan;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $laporan = LapharKegiatanKamtibmas::with('kegiatans')->find($id);
        $kegiatans = ListKegiatan::query()->pluck('nama', 'id');
        return view('administrator.sislap.nonlapbul.laphar-kegiatan-kamtibmas.edit', [
            'kegiatans' => $kegiatans,
            'laporan'   => $laporan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kegiatan' => ['required', 'array']
        ]);

        $input = $request->get('kegiatan');
        if(count($input) < ListKegiatan::count()){
            throw ValidationException::withMessages(['kegiatan' => 'Seluruh kegiatan harus diisi!']);
        }
        $inputKegiatan = collect($input)->flatten();
        if($inputKegiatan->filter(fn ($item, $key) => !is_numeric($item))->count() > 0){
            throw ValidationException::withMessages(['kegiatan' => 'Isian jumlah kegiatan harus berupa angka!']);
        }

        $laporan = LapharKegiatanKamtibmas::find($id);
        DB::beginTransaction();
        try {
            $laporan->update(['total_kegiatan' => $inputKegiatan->sum()]);
            $laporan->kegiatans()->sync($input);
            DB::commit();
            $this->flashSuccess('Laporan berhasil diperbarui');
            return redirect()->route('laphar-kegiatan-kamtibmas.index');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->flashError('Laporan gagal diperbarui: ' + $e->getMessage());
            return redirect()->back();

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
            DB::transaction(function () use ($id) {
                LapharKegiatanKamtibmas::find($id)->delete();
            });
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

    public function templateExcel()
    {
        $additionalName = '';
        if (auth()->user()->haveRoleID([User::BAGOPSNALEV_POLDA, User::BAGOPSNALEV_POLRES])) {
            $additionalName .= (' '.auth()->user()->personel->polda);
            if (auth()->user()->haveRoleID(User::BAGOPSNALEV_POLRES)) {
                $additionalName .= (' '.auth()->user()->personel->satker);
            }
        }

        return (new LapharKegiatanKamtibmasExport(true))
            ->download('FORMAT LAPHAR RUTIN DITBINMAS POLDA'
                .$additionalName.' '
                .now()->format('Y-m-d')
                .'.xlsx'
            );
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
        return (new LapharKegiatanKamtibmasExport(false))
            ->download('EKSPOR LAPHAR RUTIN DITBINMAS POLDA'
                .$additionalNotes
                .'.xlsx'
            );
    }
}
