<?php

namespace App\Http\Controllers\PolisiRW;

use App\Http\Controllers\Controller;
use App\Models\PolisiRW\KategoriKerawanan;
use Illuminate\Http\Request;

class KategoriKerawananController extends Controller
{
    public function index()
    {
        $data = KategoriKerawanan::get();
        if (request()->wantsJson()){
            return response()->json($data->pluck('nama', 'id')->toArray());
        }
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(KategoriKerawanan $kategoriKerawanan)
    {
    }

    public function edit(KategoriKerawanan $kategoriKerawanan)
    {
    }

    public function update(Request $request, KategoriKerawanan $kategoriKerawanan)
    {
    }

    public function destroy(KategoriKerawanan $kategoriKerawanan)
    {
    }
}
