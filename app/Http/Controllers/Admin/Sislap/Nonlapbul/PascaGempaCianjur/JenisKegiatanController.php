<?php

namespace App\Http\Controllers\Admin\Sislap\Nonlapbul\PascaGempaCianjur;

use App\Http\Controllers\Controller;
use App\Models\Sislap\Nonlapbul\PascaGempaCianjur\JenisGiatPascaGempa;
use App\Models\Sislap\Nonlapbul\PascaGempaCianjur\JenisLaporanPascaGempa;
use Illuminate\Http\Request;

class JenisKegiatanController extends Controller
{
    public function select2()
    {
        $query = JenisGiatPascaGempa::query();
        $query->when(request('q'), function ($query) {
            $query->where('nama', 'ilike', '%' . request('q') . '%');
        });
        $query->when(request()->has('jenis_laporan'), function ($query) {
            $query->whereHas('jenis_laporans', function ($query) {
                $query->where('jenis_laporan', request('jenis_laporan'));
            });
        });
        $data = $this->mapForSelect2($query->orderBy('created_at')->get());
        if (request()->ajax()) {
            return response()->json($data);
        }
        return $data;
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required',
            'slug' => 'required',
        ]);
        $jenisGiatPascaGempa = JenisGiatPascaGempa::firstOrCreate(
            ['slug' => $request->slug],
            ['nama' => $request->nama, 'created_by' => auth()->user()->id]
        );
        JenisLaporanPascaGempa::firstOrCreate([
            'jenis_giat_pasca_gempa_id' => $jenisGiatPascaGempa->id,
            'jenis_laporan' => $request->jenis_laporan,
        ]);
        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $jenisGiatPascaGempa
        ]);
    }

    private function mapForSelect2($data)
    {
        return $data->map(function ($item) {
            return [
                'id' => $item->slug,
                'text' => $item->nama
            ];
        });
    }
}
