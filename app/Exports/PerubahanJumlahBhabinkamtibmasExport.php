<?php

namespace App\Exports;

use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\SupervisorPolmasService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class PerubahanJumlahBhabinkamtibmasExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    private $path = 'excel.kinerja-bhabinkamtibmas.lampiran-nrp-bhabinkamtibmas';

    public function view(): View
    {
        return view($this->path);
    }

    public function registerEvents(): array
    {
        /**
         * lock all row and column except nrp
         */
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                $columnsToProtect = range('B', 'Z');

                foreach($columnsToProtect as $column) {
                    $sheet->protectCells($column . '1:' . $column . '1000', 'B0SP0LR1!');
                }
                $sheet->getStyle('A2:K1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                $sheet->getDelegate()->getProtection()->setSheet(true);
            },
        ];
    }
}