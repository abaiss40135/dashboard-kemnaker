<?php

namespace App\Http\Controllers\Admin\KinerjaBhabinkamtibmas;

use App\Http\Controllers\Controller;
use App\Models\Dds_warga;
use App\Models\Personel;
use App\Models\User;
use Illuminate\Http\Request;

class ShowLaporanController extends Controller
{
    public function listDdsWarga($nrp)
    {
        $profile = implode(' ', User::where('nrp', $nrp)->leftJoin('personel', 'personel.user_id', '=', 'users.id')
                                                        ->first(['pangkat', 'nama'])->toArray());
        return view('administrator.show-laporan.list-dds-warga', compact('profile'));
    }

    public function searchListDdsWarga(Request $request)
    {
        $user_id = User::where('nrp', $request->nrp)->pluck('id');
        $search = $request->search;

        $data = Dds_warga::where('user_id', $user_id)->where(function ($query) use ($search) {
            $query->where('dds_wargas.nama_kepala_keluarga', 'ilike', '%' . $search . '%')
                  ->orWhere('dds_wargas.tanggal', 'ilike', '%' . $search . '%')
                  ->orWhere('dds_wargas.desa_kepala_keluarga', 'ilike', '%' . $search . '%')
                  ->orWhere('dds_wargas.nama_penerima_kunjungan', 'ilike', '%' . $search . '%')
                  ->orWhereHas('laporan_informasi.keywords', function ($query) use ($search) {
                    $query->where('keyword', 'ilike', '%' . $search . '%');
                });
        })->with('laporan_informasi.keywords')->paginate(10, ['*'], 'page');

        return response()->json($data);
    }

    public function detailDdsWarga($id)
    {
        $data = Dds_warga::where('id', $id)->leftJoin('personel', 'personel.user_id', '=', 'dds_wargas.user_id')
                                           ->with('laporan_informasi.keywords')
                                           ->with('pendapat_warga.keywords')->first();

        return view('administrator.show-laporan.detail-dds-warga', compact('data'));
    }
}
