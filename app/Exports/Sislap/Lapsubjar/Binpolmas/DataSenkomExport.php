<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas;

use App\Services\Sislap\Lapsubjar\Binpolmas\DataSenkomService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataSenkomExport implements FromView
{
    private bool $is_template;
    private DataSenkomService $service;

    public function __construct(DataSenkomService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service     = $service;
    }

    public function view(): View
    {
        if($this->is_template) {
            return view('excel.template-laporan.data-senkom', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-senkom', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
