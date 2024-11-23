<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanBhabinkamtibmasExport implements WithMultipleSheets
{
    use Exportable;

    protected int|string $nrp;
    protected ?string $start_date;
    protected ?string $end_date;

    public function __construct(int|string $nrp, ?string $month)
    {
        $month            = strtotime($month);
        $this->nrp        = $nrp;
        $this->start_date = $month ? date('Y-m-01 00:00:00', $month) : null;
        $this->end_date   = $month ? date('Y-m-t 23:59:59', $month) : null;
    }

    public function sheets(): array
    {
        return [
            new DdsWargaExport($this->nrp, $this->start_date, $this->end_date),
            new DeteksiDiniExport($this->nrp, $this->start_date, $this->end_date),
            new PsSengketaExport($this->nrp, $this->start_date, $this->end_date),
            new PsNonSengketaExport($this->nrp, $this->start_date, $this->end_date),
        ];
    }
}
