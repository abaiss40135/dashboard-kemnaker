<?php

namespace App\Exports\Sislap\Lapsubjar\Binkamsa;

use App\Services\Sislap\Lapsubjar\Binkamsa\PrestasiSatpamService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PrestasiSatpamExport implements FromView
{
    private bool $is_template;
    private PrestasiSatpamService $service;

    public function __construct(PrestasiSatpamService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.prestasi-satpam', ['laporans' => []]);
        }

        return view('excel.template-laporan.prestasi-satpam', [
            'laporans' => $this->service->export(request()->all()),
        ]);
    }
}
