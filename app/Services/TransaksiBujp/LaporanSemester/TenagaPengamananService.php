<?php

namespace App\Services\TransaksiBujp\LaporanSemester;

use App\Models\Bujp\LaporanSemester\TenagaPengamanan;
use App\Models\User;

class TenagaPengamananService {
    private $bulanIndonesia = [
        'January' => 'Jan',
        'February' => 'Feb',
        'March' => 'Mar',
        'April' => 'Apr',
        'May' => 'Mei',
        'June' => 'Jun',
        'July' => 'Jul',
        'August' => 'Agu',
        'September' => 'Sep',
        'October' => 'Okt',
        'November' => 'Nov',
        'December' => 'Des'
    ];

    public function search($request)
    {
        $data = $this->queryData($request, true);
        return $data->paginate();
    }

    public function export($request)
    {
        $data = $this->queryData($request);
        return $data->get();
    }

    public function sumDataExport($data)
    {
        $sums = [
            'kualifikasi_gp' => 0,
            'kualifikasi_gm' => 0,
            'kualifikasi_gu' => 0,
            'total_kualifikasi' => 0,
            'perumahan' => 0,
            'hotel' => 0,
            'rumah_sakit' => 0,
            'perbankan' => 0,
            'pabrik' => 0,
            'toko' => 0,
            'perkebunan' => 0,
            'tambang' => 0,
            'kantor' => 0,
            'transportasi' => 0,
            'pendidikan' => 0,
        ];

        foreach($data as $item) {
            $sums['kualifikasi_gp'] += $item->kualifikasi_gp;
            $sums['kualifikasi_gm'] += $item->kualifikasi_gm;
            $sums['kualifikasi_gu'] += $item->kualifikasi_gu;
            $sums['perumahan'] += $item->perumahan;
            $sums['hotel'] += $item->hotel;
            $sums['rumah_sakit'] += $item->rumah_sakit;
            $sums['perbankan'] += $item->perbankan;
            $sums['pabrik'] += $item->pabrik;
            $sums['toko'] += $item->toko;
            $sums['perkebunan'] += $item->perkebunan;
            $sums['tambang'] += $item->tambang;
            $sums['kantor'] += $item->kantor;
            $sums['transportasi'] += $item->transportasi;
            $sums['pendidikan'] += $item->pendidikan;
        }

        $sums['total_kualifikasi'] = $sums['kualifikasi_gp'] + $sums['kualifikasi_gm'] + $sums['kualifikasi_gu'];

        return $sums;
    }

    public function queryData($request, $withApproval = null)
    {
        $query = TenagaPengamanan::query()->with('bujp');

        $query
            ->when($withApproval, function ($query) {
                return $query->with('approvals');
            })
            ->when(roles(['operator_mabes_2', 'operator_mabes']), function($q) {
                return $q->whereHas('approvals', function($q) {
                    $q->where('level', 'bujp');
                });
            })
            ->when($request->search, function($querySearch, $search) {
            return $querySearch->where(function($q) use ($search){
                 $q->where('pengguna_jasa', 'ilike', '%' . $search . '%')
                     ->orWhere('no_sio', 'ilike', '%' . $search . '%')
                     ->orWhereHas('bujp', function($q) use ($search) {
                         $q->where('nama_badan_usaha', 'ilike', '%' . $search . '%');
                     })
                     ->orWhere('kualifikasi_gp', 'ilike', '%' . $search . '%')
                     ->orWhere('kualifikasi_gm', 'ilike', '%' . $search . '%')
                     ->orWhere('kualifikasi_gu', 'ilike', '%' . $search . '%');
            });
        });
            // belum ada filter untuk tanggal sio
//            ->when($request->tanggal_sio, function($queryTanggalSio, $request) {
//                $convertDate = $this->convertDate($request->tanggal_sio);
//                return $queryTanggalSio->where('no_sio', 'ilike', '%' . $convertDate . '%');
//            });

        return $query->orderBy('created_at', 'desc');
    }

    private function convertDate($dateString)
    {
        $date = new \DateTime($dateString);
        $month = $date->format('F');
        $indonesiaMonth = $this->bulanIndonesia[$month];
        $formatDate = $date->format('d') . ' ' . $indonesiaMonth . ' ' . $date->format('Y');

        return $formatDate;
    }
}