<?php

namespace App\Exports\Sislap\Lapsubjar\Bhabin;

use App\Services\Sislap\Lapsubjar\Bhabin\RekapPenghargaanService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapPenghargaanExport implements FromView
{
    private bool $is_template;
    private RekapPenghargaanService $service;

    public function __construct(RekapPenghargaanService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.rekap-penghargaan', ['laporans' => []]);
        }

        return view('excel.template-laporan.rekap-penghargaan', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
