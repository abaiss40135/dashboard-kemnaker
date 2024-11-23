<?php

namespace App\Exports\Sislap\Lapsubjar\Sipolsus;

use App\Services\Sislap\Lapsubjar\Sipolsus\DataPensiunPolsusService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class DataPensiunPolsusExport implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    use Exportable;

    private $dataPensiunPolsusService;
    private $jenisPolsus;

    private $path = "excel.template-laporan.sipolsus.template-data-polsus-aktif-dan-pensiun-export";

    public function __construct($jenisPolsus)
    {
        $this->dataPensiunPolsusService = new DataPensiunPolsusService($jenisPolsus);
        $this->jenisPolsus = $jenisPolsus;
    }

    public function view(): View
    {
        $laporans = $this->dataPensiunPolsusService->export(request());
        $sums = $this->dataPensiunPolsusService->sumExport($laporans);

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
