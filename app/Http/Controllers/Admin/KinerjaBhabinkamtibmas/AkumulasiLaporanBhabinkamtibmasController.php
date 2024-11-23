<?php

namespace App\Http\Controllers\Admin\KinerjaBhabinkamtibmas;

use App\Exports\KinerjaBhabinkamtibmas\AkumulasiLaporanBhabinkamtibmasExport;
use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use Maatwebsite\Excel\Excel;

class AkumulasiLaporanBhabinkamtibmasController extends Controller
{
    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Excel $excel, AkumulasiLaporanBhabinkamtibmasExport $export)
    {
        $polda = Provinsi::where('code', request('province_code'))->first()->polda;
        return $excel->download($export, sprintf('REKAP-AKUMULASI-BHABINKAMTIBMAS-%s-%s%s', $polda, request('periode'),'.xlsx'));
    }
}
