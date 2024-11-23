<?php

namespace App\Exports\Sislap\Lapsubjar\Binkamsa;

use App\Services\Sislap\Lapsubjar\Binkamsa\TindakPidanaSatpamService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TindakPidanaSatpamExport implements FromView
{
    private bool $is_template;
    private TindakPidanaSatpamService $service;

    public function __construct(TindakPidanaSatpamService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.tindak-pidana-satpam', ['laporans' => []]);
        }

        return view('excel.template-laporan.tindak-pidana-satpam', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
