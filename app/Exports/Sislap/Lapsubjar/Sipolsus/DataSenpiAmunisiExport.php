<?php

namespace App\Exports\Sislap\Lapsubjar\Sipolsus;

use App\Helpers\ApiHelper;
use App\Services\Sislap\Lapsubjar\Sipolsus\DataSenpiAmunisiService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;

class DataSenpiAmunisiExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    private $dataSenpiAmunisiService;
    private $jenisPolsus;

    private $path = "excel.template-laporan.sipolsus.template-data-senpi-amunisi-export";

    public function __construct($jenisPolsus)
    {
        $this->dataSenpiAmunisiService = new DataSenpiAmunisiService($jenisPolsus);
        $this->jenisPolsus = $jenisPolsus;
    }

    public function view(): View
    {
        $laporans = $this->dataSenpiAmunisiService->export(request());
        $sums = $this->dataSenpiAmunisiService->sumExport($laporans);

        return view($this->path, [
            'laporans' => $laporans,
            'sums' => $sums,
            'jenisPolsus' => $this->jenisPolsus
        ]);
    }


    public function registerEvents(): array
    {
        return [];
    }
}
