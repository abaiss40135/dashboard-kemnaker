<?php

namespace App\Exports\Sislap\Lapsubjar\Sipolsus;

use App\Helpers\ApiHelper;
use App\Models\Polsus;
use App\Services\Sislap\Lapsubjar\Sipolsus\DataDiklatDanKepemilikanKtaService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\{
    ShouldAutoSize,
    WithEvents,
    WithStrictNullComparison,
    FromView,
    Exportable
};

class DataDiklatDanKepemilikanKtaExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    private $dataDiklatDanKepemilikanKtaService;

    //path lama dan mandiri
    //private $path = 'excel.template-laporan.sipolsus.data-diklat-reguler';

    //path baru dan universal
    private $path = "excel.template-laporan.sipolsus.template-excel-sipolsus";

    public function __construct($jenjang_diklat, $kepemilikan_kta = false)
    {
        $this->dataDiklatDanKepemilikanKtaService = new DataDiklatDanKepemilikanKtaService($jenjang_diklat, $kepemilikan_kta);
    }

    public function view(): View
    {
        $laporans = $this->dataDiklatDanKepemilikanKtaService->export(request());
        $sums = $this->dataDiklatDanKepemilikanKtaService->sumExport($laporans);

        return view($this->path, [
            "sums" => $sums,
            "laporans" => $laporans,
            'polices' => $this->dataDiklatDanKepemilikanKtaService->polices,
            'attributes' => $this->dataDiklatDanKepemilikanKtaService->attributes,
        ]);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lockRange = 'A3:C3';
                $editableRange = 'D3:AG3';
                if (auth()->user()->haveRole('operator_bagopsnalev_polda')){
                    $countRows = (2 + count(ApiHelper::getChildSatuanByKodeSatuan(substr(auth()->user()->personel->kode_satuan, 0, 3), true)));
                    $lockRange = 'A3:C' . $countRows;
                    $editableRange = 'D3:AG' . $countRows;
                }
                $sheet = $event->sheet;
                $sheet->protectCells('A1:AG2', 'B0SP0LR1!');
                $sheet->protectCells($lockRange, 'B0SP0LR1!');
                $sheet->getStyle($editableRange)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                //A2:G10 is the range which can be editable
                $sheet->getDelegate()->getProtection()->setSheet(true);
            },
        ];
    }
}
