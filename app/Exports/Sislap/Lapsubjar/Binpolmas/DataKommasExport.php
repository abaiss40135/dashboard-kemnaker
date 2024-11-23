<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas;

use App\Services\Sislap\Lapsubjar\Binpolmas\DataKommasService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataKommasExport implements FromView
{
    private bool $is_template;
    private DataKommasService $service;

    public function __construct(DataKommasService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-kommas', ['laporans' => []]);
        }
        return view('excel.template-laporan.data-kommas', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
