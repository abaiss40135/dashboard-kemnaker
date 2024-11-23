<?php

namespace App\Exports\Sislap\Nonlapbul;

use App\Helpers\ApiHelper;
use App\Services\Sislap\Nonlapbul\PreemtifBbmService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class PreemtifBbmExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    private $PreemtifBbmService;
    private $is_template;
    private $path = 'excel.template-laporan.preemtif-bbm';

    public function __construct(bool $is_template = false)
    {
        $this->PreemtifBbmService = new PreemtifBbmService();
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            $data['laporans'] = [];
            if (auth()->user()->haveRole('operator_bagopsnalev_polda')) {
               $data['satuans'] = ApiHelper::getChildSatuanByKodeSatuan(substr(auth()->user()->personel->kode_satuan, 0, 3), true);
            }
            return view($this->path, $data);
        }
        $collection = $this->PreemtifBbmService->export(request());

        return view($this->path, [ 'laporans' => $collection ]);
    }


    public function registerEvents(): array
    {
        if ($this->is_template) {
            return [
                AfterSheet::class => function(AfterSheet $event) {
                    $lockRange = 'A1:C2';
                    $editableRange = 'D2:F2';
                    if (auth()->user()->haveRole('operator_bagopsnalev_polda')) {
                        $countRows = (1 + count(ApiHelper::getChildSatuanByKodeSatuan(substr(auth()->user()->personel->kode_satuan, 0, 3), true)));
                        $lockRange = 'A1:C' . $countRows;
                        $editableRange = 'D2:F' . $countRows;
                    }
                    $sheet = $event->sheet;
                    $sheet->protectCells('A1:F1', config('sislap.password'));
                    $sheet->protectCells($lockRange, config('sislap.password'));
                    $sheet->getStyle($editableRange)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    $sheet->getDelegate()->getProtection()->setSheet(true);
                },
            ];
        }
        return [];
    }
}
