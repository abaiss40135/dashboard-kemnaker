<?php

namespace App\Http\Controllers;

use App\Models\PolisiRW\Pekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
    public function index()
    {
        $data = Pekerjaan::get();
        if (request()->wantsJson()){
            return response()->json($data->pluck('name', 'id')->toArray());
        }
        return $data;
    }

    public function select2(Request $request)
    {
        $data = Pekerjaan::get();
        return response()->json($data->pluck('name', 'id')->toArray());
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Pekerjaan $pekerjaan)
    {
    }

    public function edit(Pekerjaan $pekerjaan)
    {
    }

    public function update(Request $request, Pekerjaan $pekerjaan)
    {
    }

    public function destroy(Pekerjaan $pekerjaan)
    {
    }
}
