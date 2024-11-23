<?php

namespace App\Exports\Sislap\Lapsubjar\Binkamsa;

use App\Services\Sislap\Lapsubjar\Binkamsa\PelaksanaanDiklatService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PelaksanaanDiklatExport implements FromView
{
    private bool $is_template;
    private PelaksanaanDiklatService $service;

    public function __construct(PelaksanaanDiklatService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.pelaksanaan-diklat', [
                'laporans' => []
            ]);
        }
        return view('excel.template-laporan.pelaksanaan-diklat', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
