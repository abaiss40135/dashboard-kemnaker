<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas;

use App\Services\Sislap\Lapsubjar\Binpolmas\KbppPolriService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KbppPolriExport implements FromView
{
    private bool $is_template;
    private KbppPolriService $service;

    public function __construct(KbppPolriService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service     = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.kbpp-polri', ['laporans' => []]);
        }
        return view('excel.template-laporan.kbpp-polri', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
