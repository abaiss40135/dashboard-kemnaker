<?php

namespace App\Exports\Sislap\Nonlapbul;

use App\Services\Sislap\Nonlapbul\OpsDamaiCartenzService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class OpsDamaiCartenzExport implements FromView, ShouldAutoSize, WithStrictNullComparison, WithEvents
{
    use Exportable;

    private OpsDamaiCartenzService $service;
    private bool   $is_bagopsnalev_polda;
    private array  $satuans;
    private string $path = 'excel.template-laporan.ops-damai-cartenz';
    private array  $satuan_default = [
        'KABUPATEN PEGUNUNGAN BINTANG',
        'KABUPATEN YAHUKIMO',
        'KABUPATEN INTAN JAYA',
        'KABUPATEN PUNCAK',
        'KABUPATEN NDUGA',
        'KABUPATEN DOGIYAI',
        'KOTA JAYAPURA',
        'KABUPATEN MIMIKA',
        'KABUPATEN JAYAWIJAYA',  
    ];

    public function __construct(private string $type, private bool $is_template = false)
    {
        $this->is_bagopsnalev_polda = auth()->user()->haveRole('operator_bagopsnalev_polda');
        $this->service     = new OpsDamaiCartenzService($type);
        $this->is_template = $is_template;
        $this->satuans     = match($this->is_bagopsnalev_polda) {
            true  => $this->satuan_default,
            false => array_values(preg_grep("/".substr(strstr(auth()->user()->personel->polres, " "), 1)."/", $this->satuan_default))
        };
    }

    public function view(): View
    {
        $data = [
            'laporans' => [],
            'satuans'  => [],
        ];

        if ($this->is_template) {
            $data['satuans'] = $this->satuans;
            return view($this->path, $data);
        }

        $data['laporans'] = $this->service->export(request());
        return view($this->path, $data);
    }

    public function registerEvents(): array
    {
        if ($this->is_template){
            /**
             * lock polda dan polres from editing
             */
            return [
                AfterSheet::class => function(AfterSheet $event) {
                    $lockRange = 'A2:B2';
                    $editableRange = 'C2:L2';
                    $countRows = (1 + count($this->satuans));
                    $lockRange = 'A2:B' . $countRows;
                    $editableRange = 'C2:L' . $countRows;
                    $sheet = $event->sheet;

                    $sheet->protectCells($lockRange, 'B0SP0LR1!');
                    $sheet->getStyle($editableRange)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    $sheet->getDelegate()->getProtection()->setSheet(true);
                },
            ];
        }
        return [];
    }
}
