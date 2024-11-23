<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Helpers\ApiHelper;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\PembinaPolmasService;
use App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru\SupervisorPolmasService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class PembinaPolmasExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    private $pembinaPolmasService;
    private $is_template;
    private $path = 'excel.template-laporan.binpolmas.pembina-polmas';
    private $is_bagopsnalev_polda;
    private $satuans = [];

    public function __construct(bool $is_template = false)
    {
        $this->pembinaPolmasService = new PembinaPolmasService();
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
            $data["anggota_polri"] = true;
            if ($this->is_bagopsnalev_polda) {
                $data['satuans'] = $this->satuans;
            }
            return view($this->path, $data);
        }
        $collection = $this->pembinaPolmasService->export(request());
        return view($this->path, [
            'laporans' => $collection,
            'columns' => collect($this->pembinaPolmasService->columns)->except(PembinaPolmasService::INDEX_LAMPIRAN_FILE)->toArray(),
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
                    $sheet = $event->sheet;
                    $sheet->protectCells('A1:E1', 'B0SP0LR1!');
                    $sheet->getStyle('A2:E10000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    $sheet->getDelegate()->getProtection()->setSheet(true);
                },
            ];
        }
        return [];
    }
}