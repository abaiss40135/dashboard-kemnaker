<?php

namespace App\Exports\Sislap\Lapsubjar\Binkamsa;

use App\Services\Sislap\Lapsubjar\Binkamsa\PagelaranSatpamService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PagelaranSatpamExport implements FromView
{
    private bool $is_template;
    private PagelaranSatpamService $service;

    public function __construct(PagelaranSatpamService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.pagelaran-satpam', ['laporans' => []]);
        }
        return view('excel.template-laporan.pagelaran-satpam', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
