<?php

namespace App\Http\Controllers\Bujp\TransaksiSatpam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bujp;
use App\Models\Satpam;
use App\Repositories\Export\ExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ExportController extends Controller
{


    public function exportCsv(Request $request)
    {
        $bujp = Bujp::where('user_id' , auth()->user()->id)->first();
        $satpams = Satpam::where('bujp_id', $bujp->id)->get();
        $fileName = 'satpam.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array(
            'nama', 'no_ktp', 'jenis_kelamin', 'tempat_lahir',
            'tanggal_lahir', 'nomor_hp', 'agama',
            'provinsi', 'kebupaten', 'kecamatan', 'desa',
            'rt', 'rw', 'detail_alamat',
            'tempat_tugas', 'no_kta', 'tanggal_terbit_kta',
        );

        $callback = function() use($satpams, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($satpams as $satpam) {
                $row['nama'] = $satpam->nama;
                $row['nomor ktp']   = $satpam->no_ktp;
                $row['jenis kelamin']   = $satpam->jenis_kelamin;
                $row['tempat lahir'] = $satpam->tempat_lahir;
                $row['tanggal lahir'] = $satpam->tanggal_lahir;
                $row['nomor hp'] = $satpam->no_hp;
                $row['agama'] = $satpam->agama;
                $row['provinsi'] = $satpam->provinsi;
                $row['kabupaten'] = $satpam->kabupaten;
                $row['kecamatan'] = $satpam->kecamatan;
                $row['desa'] = $satpam->desa;
                $row['rt'] = $satpam->rt;
                $row['rw'] = $satpam->rw;
                $row['detail alamat'] = $satpam->detail_alamat;
                $row['tempat tugas'] = $satpam->tempat_tugas;
                $row['nomor kta'] = $satpam->no_kta;
                $row['tanggal terbit kta'] = $satpam->tanggal_terbit_kta;

                fputcsv($file, array(
                    $row['nama'],
                    $row['nomor ktp'],
                    $row['jenis kelamin'],
                    $row['tempat lahir'],
                    $row['tanggal lahir'],
                    $row['nomor hp'],
                    $row['agama'],
                    $row['provinsi'],
                    $row['kebupaten'],
                    $row['kecamatan'],
                    $row['desa'],
                    $row['rt'],
                    $row['rw'],
                    $row['detail alamat'],
                    $row['tempat tugas'],
                    $row['nomor kta'],
                    $row['tanggal terbit kta']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel(Satpam $satpam){
        $excel = new ExcelExport;

        return Excel::download( $excel, 'satpam.xlsx');
    }

    public function exportPdf(){
        $data = Satpam::all();

        $pdf = PDF::loadView('templates.admin.export' , compact('data'));
        return $pdf->stream('satpam.pdf');
    }
}
