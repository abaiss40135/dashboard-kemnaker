<?php

namespace App\Exports\Sislap\Lapsubjar\Binanevpolsus;

use App\Services\Sislap\Lapsubjar\Binanevpolsus\DataGiatKorwasService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataGiatKorwas implements FromView
{
    private bool $is_template;
    private $service;

    public function __construct(DataGiatKorwasService $service, bool $is_template = false) {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-giat-korwas', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-giat-korwas', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
