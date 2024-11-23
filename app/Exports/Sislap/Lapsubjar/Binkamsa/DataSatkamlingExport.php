<?php

namespace App\Exports\Sislap\Lapsubjar\Binkamsa;

use App\Services\Sislap\Lapsubjar\Binkamsa\DataSatkamlingService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataSatkamlingExport implements FromView
{
    private bool $is_template;
    private DataSatkamlingService $service;

    public function __construct(DataSatkamlingService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-satkamling', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-satkamling', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
