<?php

namespace App\Http\Controllers\PolisiRW;

use App\Http\Controllers\Controller;
use App\Http\Requests\PolisiRW\LokasiPenugasanStoreRequest;
use App\Models\PolisiRW\LokasiPenugasan;
use Illuminate\Http\Request;

class LokasiPenugasanController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        $polda      = auth()->user()->personel->polda;
        return view('polisi-rw.lokasi-penugasan.create', compact('polda'));
    }

    public function store(LokasiPenugasanStoreRequest $request)
    {
        try {
            LokasiPenugasan::create([
                'user_id' => auth()->user()->id,
                'province_code' => substr($request->village_code, 0, 2),
                'city_code' => substr($request->village_code, 0, 4),
                'district_code' => substr($request->village_code, 0, 6),
                'village_code' => $request->village_code,
                'dusun' => $request->dusun,
                'rw' => $request->rw
            ]);
            $this->flashSuccess('Terimakasih, berhasil menambahkan lokasi penugasan');
            return redirect()->route('polisi_rw');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function show(LokasiPenugasan $lokasiPenugasan)
    {
    }

    public function edit(LokasiPenugasan $lokasiPenugasan)
    {
    }

    public function update(Request $request, LokasiPenugasan $lokasiPenugasan)
    {
    }

    public function destroy(LokasiPenugasan $lokasiPenugasan)
    {
    }
}
