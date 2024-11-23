<?php

namespace App\Exports\Sislap\Lapsubjar\Binanevpolsus;

use App\Services\Sislap\Lapsubjar\Binanevpolsus\DataKejadianService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataKejadian implements FromView
{
    private bool $is_template;
    private $service;

    public function __construct(DataKejadianService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if($this->is_template) {
            return view('excel.template-laporan.data-kejadian', ['laporans' => []]);
        }
        return view('excel.template-laporan.data-kejadian', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
