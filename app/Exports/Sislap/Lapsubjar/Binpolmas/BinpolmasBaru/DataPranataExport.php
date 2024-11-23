<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Helpers\ApiHelper;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataPranataService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class DataPranataExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    private $DataPranataService;
    private $is_template;
    private $path = 'excel.template-laporan.data-pranata';
    private $is_bagopsnalev_polda;
    private $satuans = [];

    public function __construct(bool $is_template = false)
    {
        $this->DataPranataService = new DataPranataService();
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

        $collection = $this->DataPranataService->export(request());

        return view($this->path, [
            'laporans' => $collection,
            'columns' => $this->DataPranataService->columns,
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
                    $editableRange = 'D3:S3';
                    if ($this->is_bagopsnalev_polda) {
                        $countRows = (1 + count($this->satuans));
                        $lockRange = 'A2:C2' . $countRows;
                        $editableRange = 'D3:S3' . $countRows;
                    }
                    $sheet = $event->sheet;
                    $sheet->protectCells('A1:S1', 'B0SP0LR1!');
                    $sheet->protectCells($lockRange, 'B0SP0LR1!');
                    $sheet->getStyle($editableRange)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    $sheet->getDelegate()->getProtection()->setSheet(true);
                },
            ];
        }
        return [];
    }
}
