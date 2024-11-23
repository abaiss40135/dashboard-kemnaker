<?php

namespace App\Exports\Sislap\Lapsubjar\Binkamsa;

use App\Services\Sislap\Lapsubjar\Binkamsa\HasilPelaksanaanService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class HasilPelaksanaanExport implements FromView
{
    private bool $is_template;
    private $service;

    public function __construct(HasilPelaksanaanService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service     = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.hasil-pelaksanaan', ['laporans' => []]);
        }
        return view('excel.template-laporan.hasil-pelaksanaan', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
