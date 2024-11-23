<?php

namespace App\Http\Controllers\Bhabin;

use App\Http\Controllers\Controller;
use App\Models\Personel;
use App\Models\SatuanKerja;
use Illuminate\Http\Request;

class SatuanKerjaController extends Controller
{
    public function getSelect2Data(Request $request)
    {
        if (request()->ajax()){
            return SatuanKerja::where('name', 'ILIKE', '%'.$request->term.'%')
                ->get()
                ->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'text' => $data->name
                    ];
                })
                ->values();
        }
    }

    public function updateSatuanKerja(Request $request)
    {
        $validated = $request->validate([
            'satuan_kerja_id' => 'required|exists:satuan_kerja,id'
        ]);

        Personel::where('user_id', auth()->user()->id)->update([
            'satuan_kerja_id' => $validated['satuan_kerja_id']
        ]);

        $this->flashSuccess('satuan kerja berhasil diperbarui');

        return redirect()->back();
    }
}
