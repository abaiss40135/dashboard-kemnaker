<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\{
    Helpers\ApiHelper,
    Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\DataKomunitasMasyarakatService
};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\{
    Exportable,
    FromView,
    ShouldAutoSize,
    WithStrictNullComparison,
};
use Maatwebsite\Excel\Events\AfterSheet;

class DataKomunitasMasyarakatExport implements FromView, ShouldAutoSize, WithStrictNullComparison
{
    use Exportable;

    private $service;
    private $is_template;
    private $path = 'excel.template-laporan.binpolmas.komunitas-masyarakat';
    private $is_bagopsnalev_polda;
    private $satuans = [];

    public function __construct(bool $is_template = false)
    {
        $this->service = new DataKomunitasMasyarakatService();
        $this->is_template = $is_template;
        $this->is_bagopsnalev_polda = roles(['operator_bagopsnalev_polda']);
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

        $collection = $this->service->export(request());

        return view($this->path, [
            'laporans' => $collection
        ]);
    }
    public function registerEvents(): array
    {
        if ($this->is_template) {
            /**
             * lock polda dan polres from editing
             */
            return [
                AfterSheet::class => function (AfterSheet $event) {
                    $lockRange = 'A3:C3';
                    $editableRange = 'D3:S3';
                    if ($this->is_bagopsnalev_polda) {
                        $countRows = (1 + count($this->satuans));
                        $lockRange = 'A3:C3' . $countRows;
                        $editableRange = 'D3:S3' . $countRows;
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
