<?php

namespace App\Exports\Sislap\Lapsubjar\Bintibsos;

use App\Services\Sislap\Lapsubjar\Bintibsos\GiatPembinaanService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GiatPembinaan implements FromView
{
    private $is_template;
    private $giatPembinaanService;

    public function __construct(GiatPembinaanService $giatPembinaanService, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->giatPembinaanService = $giatPembinaanService;
    }

    public function view(): View
    {
        if($this->is_template) {
            return view('excel.template-laporan.giat-pembinaan', ['laporans' => []]);
        }

        return view('excel.template-laporan.giat-pembinaan', [
            'laporans' => $this->giatPembinaanService->export(request()->all())
        ]);
    }
}
