<?php

namespace App\Http\Controllers\PolisiRW;

use App\Http\Controllers\Controller;
use App\Models\PolisiRW\KetuaRW;
use Illuminate\Http\Request;

class KetuaRWController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('polisi-rw.ketua-rw.create');
    }

    public function store(Request $request)
    {
        try {
            KetuaRW::create(array_merge([
                'personel_id' => auth()->user()->personel->personel_id
            ], $request->all()));
            $this->flashSuccess('Sukses menyimpan data');
            return redirect()->route('polisi-rw.laporan.index');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
            return redirect()->back();
        }
    }

    public function show(KetuaRW $ketuaRW)
    {
        dd($ketuaRW);
    }

    public function edit(KetuaRW $ketuaRw)
    {
        return view('polisi-rw.ketua-rw.edit', ['data' => $ketuaRw->load('desa')]);
    }

    public function update(Request $request, KetuaRW $ketuaRw)
    {
        try {
            $ketuaRw->update($request->all());
            $this->flashSuccess('Sukses menyimpan data');
            return redirect()->route('polisi-rw.laporan.index');
        } catch (\Exception $exception){
            $this->flashError($exception->getMessage());
            return back();
        }
    }

    public function destroy(KetuaRW $ketuaRW)
    {
    }
}
