<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Helpers\ApiHelper;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataFkpmWilayahService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class DataFkpmWilayahExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    private $DataFkpmWilayahService;
    private $is_template;
    private $path = 'excel.template-laporan.data-fkpm-wilayah';
    private $is_bagopsnalev_polda;
    private $satuans = [];

    public function __construct(bool $is_template = false)
    {
        $this->DataFkpmWilayahService = new DataFkpmWilayahService();
        $this->is_template = $is_template;
        $this->is_bagopsnalev_polda = auth()->user()->haveRole('operator_bagopsnalev_polda');
        if ($this->is_bagopsnalev_polda) {
            $this->satuans = ApiHelper::getChildSatuanByKodeSatuan(substr(auth()->user()->personel->kode_satuan, 0, 3), true);
        }
    }

    public function view(): View
    {
        if ($this->is_template) {
            $data['laporans'] = [];
            if ($this->is_bagopsnalev_polda) {
               $data['satuans'] = $this->satuans;
            }
            return view($this->path, $data);
        }

        $collection = $this->DataFkpmWilayahService->export(request());

        return view($this->path, [
            'laporans' => $collection,
            'columns' => $this->DataFkpmWilayahService->columns,
        ]);
    }


    public function registerEvents(): array
    {
        if ($this->is_template){
            /**
             * lock polda dan polres from editing
             */
            return [
                AfterSheet::class => function(AfterSheet $event) {
                    $lockRange = 'A2:C2';
                    $editableRange = 'D3:Q3';
                    if ($this->is_bagopsnalev_polda) {
                        $countRows = (1 + count($this->satuans));
                        $lockRange = 'A2:C2' . $countRows;
                        $editableRange = 'D3:Q3' . $countRows;
                    }
                    $sheet = $event->sheet;
                    $sheet->protectCells('A1:G1', 'B0SP0LR1!');
                    $sheet->protectCells($lockRange, 'B0SP0LR1!');
                    $sheet->getStyle($editableRange)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    $sheet->getDelegate()->getProtection()->setSheet(true);
                },
            ];
        }
        return [];
    }
}
