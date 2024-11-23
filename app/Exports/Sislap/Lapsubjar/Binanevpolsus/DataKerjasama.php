<?php

namespace App\Exports\Sislap\Lapsubjar\Binanevpolsus;

use App\Services\Sislap\Lapsubjar\Binanevpolsus\DataKerjasamaService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataKerjasama implements FromView
{
    private bool $is_template;
    private $service;

    public function __construct(DataKerjasamaService $service, bool $is_template = false) {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-kerjasama', ['laporans' => []]);
        }
        return view('excel.template-laporan.data-kerjasama', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
