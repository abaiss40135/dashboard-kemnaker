<?php

namespace App\Exports\Sislap\Lapsubjar\Sipolsus;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\{Exportable,
    ShouldAutoSize,
    WithEvents,
    WithStrictNullComparison,
    FromView};
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RegisterPolsusExport implements FromView, ShouldAutoSize, WithStrictNullComparison, WithEvents
{
    use Exportable;

    public function __construct(private $type) { }

    public function view(): View
    {
        $admin = auth()->user()->haveRole('administrator');
        $operatorPolsusPolda = auth()->user()->haveRole('operator_polsus_polda');
        $type = $this->type;
        return view('excel.template-laporan.sipolsus.template-register-akun-polsus', compact('admin', 'operatorPolsusPolda', 'type'));
    }

    public function registerEvents(): array
    {
        $operatorKlPusat = auth()->user()->haveRole('operator_polsus_kl');
        $operatorKlProv = auth()->user()->haveRole('operator_polsus_kl_provinsi');
        $operatorKlKotaKab = auth()->user()->haveRole('operator_polsus_kl_kota_kabupaten');
        $operatorPolsusPolda = auth()->user()->haveRole('operator_polsus_polda');

//        posisi ketika tidak ada attribute email dan password
        return $this->type == 'anggota' ? $this->afterSheetAnggotaPolsus($operatorKlProv, $operatorKlKotaKab, $operatorKlPusat, $operatorPolsusPolda)
        : $this->afterSheetOperatorPolsus($operatorKlProv, $operatorKlKotaKab, $operatorKlPusat, $operatorPolsusPolda);
    }

    private function afterSheetOperatorPolsus($operatorKlProv, $operatorKlKotaKab, $operatorKlPusat, $operatorPolsusPolda) {
        return [
            AfterSheet::class => function(AfterSheet $event) use ($operatorKlProv, $operatorKlKotaKab, $operatorKlPusat, $operatorPolsusPolda) {
                $sheet = $event->sheet;
                $sheet->formatColumn('F', 'yyyy-mm-dd');
                $sheet->formatColumn('W', 'yyyy-mm-dd');
                $sheet->formatColumn('X', 'yyyy-mm-dd');
                $sheet->formatColumn('AB', 'yyyy-mm-dd');
                $sheet->formatColumn('AE', 'yyyy-mm-dd');

                $sheet->setMergeCells(['A1:A2', 'B1:B2', 'C1:C2', 'D1:D2', 'E1:E2', 'F1:F2', 'G1:G2', 'H1:H2', 'I1:I2', 'J1:J2',
                    'K1:K2', 'L1:L2', 'M1:M2', 'U1:U2', 'V1:V2', 'W1:W2', 'X1:X2', 'Y1:Y2', 'Z1:Z2', 'AA1:AA2', 'AB1:AB2',
                    'AC1:AC2', 'AD1:AD2', 'AE1:AE2', 'AF1:AF2']);
                if(in_array(auth()->user()?->polsus?->instansi_id, [2,3,7,8])) {
                    $sheet->mergeCells('AG1:AG2');
                }

                // untuk alamat instansi
                $sheet->mergeCells('N1:T1');
                $sheet->setCellValue('N2', 'Provinsi');
                $sheet->setCellValue('O2', 'Kota/Kabupaten');
                $sheet->setCellValue('P2', 'Kecamatan');
                $sheet->setCellValue('Q2', 'Kelurahan/Desa');
                $sheet->setCellValue('R2', 'Detail Alamat');
                $sheet->setCellValue('S2', 'RT (Opsional)');
                $sheet->setCellValue('T2', 'RW (Opsional)');

                if($operatorKlProv || $operatorKlKotaKab || $operatorKlPusat) {
                    // $sheet->getProtection()->setSheet(true);
                    // $sheet->protectCells('L3:M1000', 'B0SP0LR1!');
                    // $sheet->protectCells('A1:AG2', 'B0SP0LR1!');

                    // $sheet->getStyle('A3:K1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    // $sheet->getStyle('N3:AG1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

                    $sheet->setCellValue('L3', auth()->user()->polsus->instansi->instansi);
                    $sheet->setCellValue('M3', ucwords( implode(' ', explode('_', auth()->user()->polsus->jenis_polsus)) ) );
                } else if($operatorPolsusPolda) {
                    // $sheet->getProtection()->setSheet(true);
                    // $sheet->protectCells('N3:N1000', 'B0SP0LR1!');
                    $sheet->setCellValue('N3', ucwords(getProvinsiOperatorPolsusPolda(auth()->user()->personel->polda)));
                    // $sheet->getStyle('A3:M1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    // $sheet->getStyle('O3:AG1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                }

                $sheet->getDelegate()->getStyle('A1:AG2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getDelegate()->getStyle('A1:AG2')->getAlignment()->setVertical(Alignment::HORIZONTAL_CENTER);
            }
        ];
    }

    private function afterSheetAnggotaPolsus($operatorKlProv, $operatorKlKotaKab, $operatorKlPusat, $operatorPolsusPolda) {
        return [
            AfterSheet::class => function(AfterSheet $event) use ($operatorKlProv, $operatorKlKotaKab, $operatorKlPusat, $operatorPolsusPolda) {
                $sheet = $event->sheet;
                $sheet->formatColumn('D', 'yyyy-mm-dd');
                $sheet->formatColumn('U', 'yyyy-mm-dd');
                $sheet->formatColumn('V', 'yyyy-mm-dd');
                $sheet->formatColumn('Z', 'yyyy-mm-dd');
                $sheet->formatColumn('AC', 'yyyy-mm-dd');

                $sheet->setMergeCells(['A1:A2', 'B1:B2', 'C1:C2', 'D1:D2', 'E1:E2', 'F1:F2', 'G1:G2', 'H1:H2', 'I1:I2', 'J1:J2',
                    'K1:K2', 'S1:S2', 'T1:T2', 'U1:U2', 'V1:V2', 'W1:W2', 'X1:X2', 'Y1:Y2', 'Z1:Z2', 'AA1:AA2',
                    'AB1:AB2', 'AC1:AC2', 'AD1:AD2']);

                if(in_array(auth()->user()?->polsus?->instansi_id, [2,3,7,8])) {
                    $sheet->mergeCells('AE1:AE2');
                }

//                untuk alamat instansi
                $sheet->mergeCells('L1:R1');
                $sheet->setCellValue('L2', 'Provinsi');
                $sheet->setCellValue('M2', 'Kota/Kabupaten');
                $sheet->setCellValue('N2', 'Kecamatan');
                $sheet->setCellValue('O2', 'Kelurahan/Desa');
                $sheet->setCellValue('P2', 'Detail Alamat');
                $sheet->setCellValue('Q2', 'RT');
                $sheet->setCellValue('R2', 'RW');

                if($operatorKlProv || $operatorKlKotaKab || $operatorKlPusat) {
                    // $sheet->getProtection()->setSheet(true);
                    // $sheet->protectCells('J3:K1000', 'B0SP0LR1!');
                    // $sheet->protectCells('A1:AG2', 'B0SP0LR1!');

                    // $sheet->getStyle('A3:I1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    // $sheet->getStyle('L3:AG1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

                    $sheet->setCellValue('J3', auth()->user()->polsus->instansi->instansi);
                    $sheet->setCellValue('K3', ucwords( implode(' ', explode('_', auth()->user()->polsus->jenis_polsus)) ) );
                } else if($operatorPolsusPolda) {
                    // $sheet->getProtection()->setSheet(true);
                    // $sheet->protectCells('L3:L1000', 'B0SP0LR1!');
                    $sheet->setCellValue('L3', ucwords(getProvinsiOperatorPolsusPolda(auth()->user()->personel->polda)));
                    // $sheet->getStyle('A3:K1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    // $sheet->getStyle('M3:AG1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                }

                $sheet->getDelegate()->getStyle('A1:AE2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getDelegate()->getStyle('A1:AE2')->getAlignment()->setVertical(Alignment::HORIZONTAL_CENTER);
            }
        ];
    }
}
