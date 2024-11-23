<?php

namespace App\Exports\Sislap\Lapsubjar\Binkamsa;

use App\Services\Sislap\Lapsubjar\Binkamsa\DataBujpService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataBujpExport implements FromView
{
    private bool $is_template;
    private DataBujpService $service;

    public function __construct(DataBujpService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-bujp', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-bujp', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
