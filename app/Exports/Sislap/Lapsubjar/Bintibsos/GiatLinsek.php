<?php

namespace App\Exports\Sislap\Lapsubjar\Bintibsos;

use App\Services\Sislap\Lapsubjar\Bintibsos\GiatLinsekService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GiatLinsek implements FromView
{
    private bool $is_template;
    private GiatLinsekService $giatLinsekService;

    public function __construct(GiatLinsekService $giatLinsekService, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->giatLinsekService = $giatLinsekService;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.giat-linsek', ['laporans' => []]);
        }

        return view('excel.template-laporan.giat-linsek', [
            'laporans' => $this->giatLinsekService->export(request()->all())
        ]);
    }
}
