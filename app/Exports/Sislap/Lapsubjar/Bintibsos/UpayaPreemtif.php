<?php

namespace App\Exports\Sislap\Lapsubjar\Bintibsos;

use App\Services\Sislap\Lapsubjar\Bintibsos\UpayaPreemtifService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UpayaPreemtif implements FromView
{
    private $is_template;
    private $upayaPreemtifService;

    public function __construct(UpayaPreemtifService $upayaPreemtifService, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->upayaPreemtifService = $upayaPreemtifService;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.upaya-preemtif', ['laporans' => []]);
        }
        return view('excel.template-laporan.upaya-preemtif', ['laporans' => $this->upayaPreemtifService->export(request()->all())]);
    }
}
