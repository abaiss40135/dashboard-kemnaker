<?php

namespace App\Exports\Sislap\Lapsubjar\Bagrenmin;

use App\Services\Sislap\Lapsubjar\Bagrenmin\SerapanAnggaranService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SerapanAnggaranExport implements FromView
{
    private $is_template;
    private $serapanAnggaranService;

    public function __construct(SerapanAnggaranService $serapanAnggaranService, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->serapanAnggaranService = $serapanAnggaranService;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.serapan-anggaran', ['laporans' => []]);
        }

        return view('excel.template-laporan.serapan-anggaran', [
            'laporans' => $this->serapanAnggaranService->export(request()->all())
        ]);
    }
}
