<?php

namespace App\Exports\Sislap\Lapsubjar\Bhabin;

use App\Services\Sislap\Lapsubjar\Bhabin\RekapPenggelaranService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapPenggelaranExport implements FromView
{
    private bool $is_template;
    private RekapPenggelaranService $service;

    public function __construct(RekapPenggelaranService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.rekap-penggelaran', ['laporans' => []]);
        }
        return view('excel.template-laporan.rekap-penggelaran', ['laporans' => $this->service->search(request()->all())]);
    }
}
