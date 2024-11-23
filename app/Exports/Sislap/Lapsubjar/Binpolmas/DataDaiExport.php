<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas;

use App\Services\Sislap\Lapsubjar\Binpolmas\DataDaiService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataDaiExport implements FromView
{
    private bool $is_template;
    private DataDaiService $service;

    public function __construct(DataDaiService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-dai', ['laporans' => []]);
        }
        return view('excel.template-laporan.data-dai', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
