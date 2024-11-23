<?php

namespace App\Http\Controllers\Laporan\Satpam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Satpam\Laporan\LaporanInformasiRequest;
use App\Models\LaporanInformasiSatpam;
use App\Models\Provinsi;
use App\Models\Satpam;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanInformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $satpam_id = Satpam::where('user_id', auth()->user()->id)->first()->id;
        $query = LaporanInformasiSatpam::query()
            ->where('satpam_id', $satpam_id)
            ->latest();

        if ($request->ajax()) {
            return DataTables::eloquent($query)
                ->addColumn('lokasi', function ($data) {
                    return $data->lokasi;
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('satpam.laporan-informasi.edit', $data->id) . '" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>' .
                        '<a data-id="' . $data->id . '" class="btn-delete btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('satpam.laporan.laporan-informasi.index', [
            'data' => $query->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('satpam.laporan.laporan-informasi.create', [
            'provinsi' => Provinsi::pluck('name', 'code')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(LaporanInformasiRequest $request)
    {
        try {
            LaporanInformasiSatpam::create(array_merge($request->validated(), [
                'satpam_id' => Satpam::where('user_id', auth()->user()->id)->first()->id
            ]));
            $this->flashSuccess('Berhasil Menambahkan Laporan');
        } catch (\Exception $e) {
            $this->flashError('Gagal Menambahkan Laporan', $e);
        }

        return redirect()->route('satpam.laporan-informasi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return LaporanInformasiSatpam::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = LaporanInformasiSatpam::findOrFail($id);
        return view('satpam.laporan.laporan-informasi.edit', [
            'laporan' => $data,
            'provinsi' => Provinsi::pluck('name', 'code')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(LaporanInformasiRequest $request, $id)
    {
        try {
            LaporanInformasiSatpam::find($id)->update($request->validated());
            $this->flashSuccess('Berhasil Mengubah Laporan');
        } catch (\Exception $e) {
            $this->flashError('Gagal Mengubah Laporan', $e->getMessage());
        }

        return redirect()->route('satpam.laporan-informasi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            LaporanInformasiSatpam::find($id)->delete();
            return $this->responseSuccess([
                'message' => 'Berhasil Menghapus Laporan'
            ]);
        } catch (\Exception $e) {
            $this->flashError('Gagal Menghapus Laporan', $e);
            return $this->responseError($e);
        }
    }
}
