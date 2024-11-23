<?php

namespace App\Exports\Sislap\Lapsubjar\Bintibsos;

use App\Helpers\ApiHelper;
use App\Services\Sislap\Lapsubjar\Bintibsos\DaiKamtibmasAnggotaPolriService;
use App\Services\Sislap\Lapsubjar\Bintibsos\DaiKamtibmasMasyarakatService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DaiKamtibmasExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison, WithColumnFormatting
{
    use Exportable;

    private $daiKamtibmasService;
    private $is_template;
    private $path = 'excel.template-laporan.bintibsos.dai-kamtibmas';
    private $is_bagopsnalev_polda;
    private $satuans = [];

    public function __construct(bool $is_template = false, $tipe)
    {
        $this->daiKamtibmasService = $tipe == "masyarakat" ?
            new DaiKamtibmasMasyarakatService() : new DaiKamtibmasAnggotaPolriService();

        $this->is_template = $is_template;
        $this->is_bagopsnalev_polda = auth()->user()->haveRole('operator_bagopsnalev_polda');
        if ($this->is_bagopsnalev_polda) {
            $this->satuans = ApiHelper::getChildSatuanByKodeSatuan(substr(auth()->user()->personel->kode_satuan, 0, 3), true);
        }
    }

    public function view(): View
    {
        $anggota_polri = $this->daiKamtibmasService instanceof DaiKamtibmasAnggotaPolriService;

        if ($this->is_template) {
            $data['laporans'] = [];
            $data["anggota_polri"] = $anggota_polri;
            if ($this->is_bagopsnalev_polda) {
                $data['satuans'] = $this->satuans;
            }
            return view($this->path, $data);
        }

        $collection = $this->daiKamtibmasService->export(request());
        return view($this->path, [
            'laporans' => $collection,
            'columns' => $this->daiKamtibmasService->columns,
            'anggota_polri' => $anggota_polri,
            'anggotaPolriColumns' => $anggota_polri ? $this->daiKamtibmasService->anggotaPolriColumns : [],
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
                    $sheet->protectCells('A1:Y1', 'B0SP0LR1!');
                    $sheet->getStyle('A2:Y1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
                    $sheet->getDelegate()->getProtection()->setSheet(true);
                },
            ];
        }
        return [];
    }

    public function columnFormats(): array
    {
        return [
            'W' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
