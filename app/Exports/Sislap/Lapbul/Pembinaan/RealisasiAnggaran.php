<?php

namespace App\Exports\Sislap\Lapbul\Pembinaan;

use App\Services\Sislap\Lapbul\Pembinaan\RealisasiAnggaranService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RealisasiAnggaran implements FromView
{
    private bool $is_template;
    private $service;

    public function __construct(RealisasiAnggaranService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.realisasi-anggaran', ['laporans' => []]);
        }
        return view('excel.template-laporan.realisasi-anggaran', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
