<?php

namespace App\Http\Controllers\PolisiRW;

use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Models\PolisiRW\Laporan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->uploadPath = 'polisi_rw';
        $this->folderName = 'laporan';
    }

    public function getNarasumber(Request $request)
    {
        return Cache::remember('polisi-rw.laporan.narasumber.' . json_encode($request->all()), defaultCacheTime(Constants::CACHE1DAY), function () use ($request) {
            return Laporan::query()
                ->when(!empty($request->nama), function ($q) use ($request) {
                    return $q->where('nama', 'ilike', "%".request('nama')."%");
                })
                ->when(!empty(request('bulan')), function ($query){
                    $date = Carbon::createFromFormat('Y-m', request('bulan'));
                    $query->whereBetween('tanggal', [
                        $date->startOfMonth()->format('Y-m-d H:i:s'),
                        $date->endOfMonth()->format('Y-m-d H:i:s')
                    ]);
                })
                ->get(['nama'])
                ->unique('nama')
                ->map(function ($item) {
                    return [
                        'id'    => $item['nama'],
                        'text'  => $item['nama']
                    ];
                });
        });
    }

    public function datatable()
    {
        if (request()->ajax()){
            $query = Laporan::query()
                ->with('kegiatan', 'kerawanan')
                ->when(!empty(request('personel_id')), function ($query){
                    return $query->where('personel_id', request('personel_id'));
                })
                ->when(!empty(request('bulan')), function ($query){
                    $date = Carbon::createFromFormat('Y-m', request('bulan'));
                    $query->whereBetween('tanggal', [
                        $date->startOfMonth()->format('Y-m-d H:i:s'),
                        $date->endOfMonth()->format('Y-m-d H:i:s')
                    ]);
                })
                ->when(!empty(request('nama')), function ($query){
                    return $query->where('nama', request('nama'));
                });

            return DataTables::eloquent($query->orderByDesc('tanggal'))
                ->addColumn('action', function ($laporan) {
                    $button = '&nbsp;<a href="' . route('polisi-rw.laporan.edit', $laporan->id) . '" class="btn btn-sm btn-primary m-2"> <i class="fas fa-pencil-alt"></i> </a>';
                    $button .= '&nbsp;<button type="button" data-id="' . $laporan->id . '" class="btn btn-delete btn-sm btn-danger m-2">
                            <i class="fas fa-trash"></i>
                          </button>';
                    return $button;
                })
                ->addColumn('status', function ($laporan) {
                    return '-';
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
        }
    }

    public function index()
    {
        return view('polisi-rw.laporan.index', [
            'count' => Laporan::where('personel_id', auth()->user()->personel->personel_id)->count()
        ]);
    }

    public function create()
    {
        return view('polisi-rw.laporan.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user()->load('personel', 'lokasi_penugasan_rw');
        $inputFoto = array();
        if ($request->file('foto')){
            $this->uploadPath = 'laporan/' . auth()->user()->nrp;
            foreach ($request->file('foto') as $file) {
                $inputFoto[] = $this->saveFiles($file);
            }
        }

        try {
            Laporan::create(array_merge([
                'personel_id' => $user->personel->personel_id,
                'village_code' => $user->lokasi_penugasan_rw->village_code,
                'kode_satuan' => $user->personel->kode_satuan,
                'foto' => json_encode($inputFoto)
            ], $request->except('foto')));

            $this->flashSuccess('Berhasil menambahkan laporan');
            return redirect()->route('polisi-rw.laporan.index');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $laporan = Laporan::query()
            ->with('kegiatan', 'kerawanan')
            ->find($id);

        return view('polisi-rw.laporan.edit', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::find($id);
        $inputFoto = array();
        if ($request->file('foto')){
            $this->uploadPath = 'laporan/' . auth()->user()->nrp;
            foreach ($request->file('foto') as $file) {
                $inputFoto[] = $this->saveFiles($file);
            }
        }

        try {
            $laporan->update(array_merge([
                'foto' => count($inputFoto) == 0 ? json_encode($laporan->foto) : json_encode($inputFoto)
            ], $request->except('foto')));
            $this->flashSuccess('Berhasil memperbarui laporan');
            return redirect()->route('polisi-rw.laporan.index');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            Laporan::find($id)->delete();
            return $this->responseSuccess([
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $exception){
            return $this->responseError($exception);
        }
    }
}
