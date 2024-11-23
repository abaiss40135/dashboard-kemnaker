<?php

namespace App\Exports\Sislap\Lapsubjar\Bhabin;

use App\Services\Sislap\Lapsubjar\Bhabin\RekapPerlengkapanService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapPerlengkapanExport implements FromView
{
    private bool $is_template;
    private RekapPerlengkapanService $service;

    public function __construct(RekapPerlengkapanService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if($this->is_template) {
            return view('excel.template-laporan.rekap-perlengkapan', ['laporans' => []]);
        }
        return view('excel.template-laporan.rekap-perlengkapan', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
