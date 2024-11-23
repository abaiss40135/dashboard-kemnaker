<?php

namespace App\Exports\Sislap\Nonlapbul\Lapharpc;

use App\Services\Sislap\Nonlapbul\LapharPcService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LapharPc implements FromView
{
    private $lapharPcService;
    private $is_template;

    public function __construct(LapharPcService $lapharPcService, bool $is_template = false)
    {
        $this->lapharPcService = $lapharPcService;
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.laphar-pc', [
                'laporans' => []
            ]);
        }

        return view('excel.template-laporan.laphar-pc', [
            'laporans' => $this->lapharPcService->export(request())
        ]);
    }
}
