<?php

namespace App\Exports\Sislap\Lapsubjar\Binkamsa;

use App\Services\Sislap\Lapsubjar\Binkamsa\DataIjazahSatpamService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataIjazahSatpamExport implements FromView
{
    private bool $is_template;
    private DataIjazahSatpamService $service;

    public function __construct(DataIjazahSatpamService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-ijazah-satpam', ['laporans' => []]);
        }
        return view('excel.template-laporan.data-ijazah-satpam', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
