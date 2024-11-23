<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas;

use App\Services\Sislap\Lapsubjar\Binpolmas\DataFkpmService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataFkpmExport implements FromView
{
    private bool $is_template;
    private DataFkpmService $service;

    public function __construct(DataFkpmService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if($this->is_template) {
            return view('excel.template-laporan.data-fkpm', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-fkpm', ['laporans' => $this->service->export(request()->all())]);
    }
}
