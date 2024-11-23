<?php

namespace App\Exports\Sislap\Nonlapbul\Lapharkarhutla;

use App\Services\Sislap\Nonlapbul\LapharKarhutlaService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LapharKarhutla implements FromView
{
    private $lapharKarhutlaService;
    private $is_template;

    public function __construct(LapharKarhutlaService $lapharKarhutlaService, bool $is_template = false)
    {
        $this->lapharKarhutlaService = $lapharKarhutlaService;
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.laphar-karhutla', [
                'laporans' => []
            ]);
        }

        return view('excel.template-laporan.laphar-karhutla', [
            'laporans' => $this->lapharKarhutlaService->export(request())
        ]);
    }
}
