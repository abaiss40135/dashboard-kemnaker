<?php

namespace App\Http\Controllers\PolisiRW;

use App\Http\Controllers\Controller;
use App\Models\PolisiRW\KategoriKegiatan;
use Illuminate\Http\Request;

class KategoriKegiatanController extends Controller
{
    public function index()
    {
        $data = KategoriKegiatan::get();
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

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
