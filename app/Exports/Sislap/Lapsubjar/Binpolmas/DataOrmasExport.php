<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas;

use App\Services\Sislap\Lapsubjar\Binpolmas\DataOrmasService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataOrmasExport implements FromView
{
    private bool $is_template;
    private DataOrmasService $service;

    public function __construct(DataOrmasService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-ormas', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-ormas', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
