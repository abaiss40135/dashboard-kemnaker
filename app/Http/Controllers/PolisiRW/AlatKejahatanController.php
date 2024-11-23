<?php

namespace App\Http\Controllers\PolisiRW;

use App\Http\Controllers\Controller;
use App\Models\PolisiRW\AlatKejahatan;
use Illuminate\Http\Request;

class AlatKejahatanController extends Controller
{
    public function index()
    {
        $data = AlatKejahatan::get();
        if (request()->wantsJson()){
            return response()->json($data->pluck('nama', 'id')->toArray());
        }
        return $data;
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(AlatKejahatan $alatKejahatan)
    {
    }

    public function edit(AlatKejahatan $alatKejahatan)
    {
    }

    public function update(Request $request, AlatKejahatan $alatKejahatan)
    {
    }

    public function destroy(AlatKejahatan $alatKejahatan)
    {
    }
}
