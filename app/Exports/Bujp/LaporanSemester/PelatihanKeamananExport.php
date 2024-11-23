<?php

namespace App\Exports\Bujp\LaporanSemester;

use App\Services\TransaksiBujp\LaporanSemester\PelatihanKeamananService;
use App\Services\TransaksiBujp\LaporanSemester\TenagaPengamananService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class PelatihanKeamananExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    private $service;
    private $path = "excel.template-laporan.bujp.laporan-semester.pelatihan-keamanan";

    public function __construct()
    {
        $this->service = new PelatihanKeamananService();
    }

    public function view(): View
    {
        [$laporans, $sums] = $this->service->export(request());

        return view($this->path, [
            "sums" => $sums,
            "laporans" => $laporans,
        ]);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lockRange = 'A2:M2';
                $editableRange = 'A3:M1000';
                $sheet = $event->sheet;
                $sheet->protectCells('A1:M2', 'B0SP0LR1!');
                $sheet->protectCells($lockRange, 'B0SP0LR1!');
                $sheet->getStyle($editableRange)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                //A2:G10 is the range which can be editable
                $sheet->getDelegate()->getProtection()->setSheet(true);
            },
        ];
    }
}
