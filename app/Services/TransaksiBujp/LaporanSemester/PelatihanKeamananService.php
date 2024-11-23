<?php

namespace App\Services\TransaksiBujp\LaporanSemester;

use App\Models\Bujp\LaporanSemester\PelatihanKeamanan;

class PelatihanKeamananService
{
    public function search($request)
    {
        $data = $this->queryData($request);
        return $data->paginate();
    }

    public function queryData($request)
    {
        $query = PelatihanKeamanan::query()->where('user_id', auth()->id())->with('bujp');

        $query->when($request->search, function($querySearch, $search) {
            return $querySearch->where(function($q) use ($search){
                $q->where('pengguna_jasa', 'ilike', '%' . $search . '%')
                    ->orWhere('no_sio', 'ilike', '%' . $search . '%')
                    ->orWhereHas('bujp', function($q) use ($search) {
                        $q->where('nama_badan_usaha', 'ilike', '%' . $search . '%');
                    })
                    ->orWhere('alamat', 'ilike', '%' . $search . '%')
                    ->orWhere('tempat_diklat', 'ilike', '%' . $search . '%')
                    ->orWhere('pihak_yang_menyewakan_tempat', 'ilike', '%' . $search . '%')
                    ->orWhere('fasilitas', 'ilike', '%' . $search . '%')
                    ->orWhere('jenis_diklat', 'ilike', '%' . $search . '%')
                    ->orWhere('waktu_diklat_dari', 'ilike', '%' . $search . '%')
                    ->orWhere('waktu_diklat_sampai', 'ilike', '%' . $search . '%')
                    ->orWhere('jumlah_peserta', 'ilike', '%' . $search . '%');
            });
        });
        // belum ada filter untuk tanggal sio
//            ->when($request->tanggal_sio, function($queryTanggalSio, $request) {
//                $convertDate = $this->convertDate($request->tanggal_sio);
//                return $queryTanggalSio->where('no_sio', 'ilike', '%' . $convertDate . '%');
//            });

        return $query->orderBy('created_at', 'desc');
    }

    public function export($request)
    {
        $data = $this->queryData($request);
        $laporans = $data->get();

        $sums = [
            'total_tempat_diklat_milik_sendiri' => (clone $data)->where('tempat_diklat', 'milik sendiri')->count(),
            'total_tempat_diklat_sewa' => (clone $data)->where('tempat_diklat', '<>', 'milik sendiri')->count(),
            'total_jenis_diklat_gp' => (clone $data)->where('jenis_diklat', 'gada pratama')->count(),
            'total_jenis_diklat_gm' => (clone $data)->where('jenis_diklat', 'gada madya')->count(),
            'total_jenis_diklat_gu' => (clone $data)->where('jenis_diklat', 'gada utama')->count(),
            'total_seluruh_peserta' => (clone $data)->sum('jumlah_peserta'),
        ];

        return [
            $laporans,
            $sums
        ];
    }
}