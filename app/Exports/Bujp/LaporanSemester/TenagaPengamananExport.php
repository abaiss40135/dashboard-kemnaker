<?php

namespace App\Exports\Bujp\LaporanSemester;

use App\Helpers\ApiHelper;
use App\Services\Sislap\Lapsubjar\Sipolsus\DataDiklatDanKepemilikanKtaService;
use App\Services\TransaksiBujp\LaporanSemester\TenagaPengamananService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class TenagaPengamananExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    private $service;
    private $path = "excel.template-laporan.bujp.laporan-semester.tenaga-pengamanan";

    public function __construct(private $isTemplate = false)
    {
        $this->service = new TenagaPengamananService();
    }

    public function view(): View
    {
        if ($this->isTemplate) {
            return view($this->path, [
                "laporans" => [],
            ]);
        }

        $laporans = $this->service->export(request());
        $sums = $this->service->sumDataExport($laporans);

        return view($this->path, [
            "sums" => $sums,
            "laporans" => $laporans,
        ]);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lockRange = 'A2:T2';
                $editableRange = 'A3:T1000';
                $sheet = $event->sheet;
                $sheet->protectCells('A1:T2', 'B0SP0LR1!');
                $sheet->protectCells($lockRange, 'B0SP0LR1!');
                $sheet->getStyle($editableRange)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                //A2:G10 is the range which can be editable
                $sheet->getDelegate()->getProtection()->setSheet(true);
            },
        ];
    }
}
