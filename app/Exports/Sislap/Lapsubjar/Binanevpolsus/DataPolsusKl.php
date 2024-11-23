<?php

namespace App\Exports\Sislap\Lapsubjar\Binanevpolsus;

use App\Services\Sislap\Lapsubjar\Binanevpolsus\DataPolsusKlService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataPolsusKl implements FromView
{
    private bool $is_template;
    private $service;

    public function __construct(DataPolsusKlService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if($this->is_template) {
            return view('excel.template-laporan.data-polsus-kl', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-polsus-kl', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
