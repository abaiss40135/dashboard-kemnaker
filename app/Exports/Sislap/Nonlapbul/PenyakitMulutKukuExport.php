<?php

namespace App\Exports\Sislap\Nonlapbul;

use App\Helpers\ApiHelper;
use App\Services\Sislap\Nonlapbul\PenyakitMulutKukuService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class PenyakitMulutKukuExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    private $penyakitMulutKukuService;
    private $is_template;
//    private $path = 'excel.template-laporan.penyakit-mulut-kuku';
    private $path = 'excel.template-laporan.penyakit-mulut-kuku-2';

    public function __construct(bool $is_template = false)
    {
        $this->penyakitMulutKukuService = new PenyakitMulutKukuService();
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            $data['laporans'] = [];
            if (auth()->user()->haveRole('operator_bagopsnalev_polda')){
               $data['satuans'] = ApiHelper::getChildSatuanByKodeSatuan(substr(auth()->user()->personel->kode_satuan, 0, 3), true);
            }
            return view($this->path, $data);
        }
        $collection = $this->penyakitMulutKukuService->export(request());

        return view($this->path, [
            'laporans' => $collection,
            'kategoris' => $this->penyakitMulutKukuService->kategori,
            'hewans' => $this->penyakitMulutKukuService->tipe,
            'sums' => $this->penyakitMulutKukuService->sumExport($collection),
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
                    $lockRange = 'A3:C3';
                    $editableRange = 'D3:AL3';
                    if (auth()->user()->haveRole('operator_bagopsnalev_polda')){
                        $countRows = (2 + count(ApiHelper::getChildSatuanByKodeSatuan(substr(auth()->user()->personel->kode_satuan, 0, 3), true)));
                        $lockRange = 'A3:C' . $countRows;
                        $editableRange = 'D3:AL' . $countRows;
                    }
                    $sheet = $event->sheet;
                    $sheet->protectCells('A1:AL2', config('sislap.password'));
                    $sheet->protectCells($lockRange, config('sislap.password'));
                    $sheet->getStyle($editableRange)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    //A2:G10 is the range which can be editable
                    $sheet->getDelegate()->getProtection()->setSheet(true);
                },
            ];
        }
        return [];
    }
}
