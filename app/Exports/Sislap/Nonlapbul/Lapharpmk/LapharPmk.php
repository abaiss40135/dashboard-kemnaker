<?php

namespace App\Exports\Sislap\Nonlapbul\Lapharpmk;

use App\Services\Sislap\Nonlapbul\LapharPmkService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LapharPmk implements FromView
{
    private $LapharPmkService;
    private $is_template;

    public function __construct(LapharPmkService $LapharPmkService, bool $is_template = false)
    {
        $this->LapharPmkService = $LapharPmkService;
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.laphar-pmk', ['laporans' => []]);
        }

        return view('excel.template-laporan.laphar-pmk', [
            'laporans' => $this->LapharPmkService->export(request())
        ]);
    }
}
