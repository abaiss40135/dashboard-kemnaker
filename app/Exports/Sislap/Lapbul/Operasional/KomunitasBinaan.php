<?php

namespace App\Exports\Sislap\Lapbul\Operasional;

use App\Services\Sislap\Lapbul\Operasional\KomunitasBinaanService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KomunitasBinaan implements FromView
{
    private bool $is_template;
    private $service;

    public function __construct(KomunitasBinaanService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.komunitas-binaan', ['laporans' => []]);
        }
        return view('excel.template-laporan.komunitas-binaan', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
