<?php

namespace App\Exports\Sislap\Lapsubjar\Bagrenmin;

use App\Services\Sislap\Lapsubjar\Bagrenmin\CapaianKinerjaService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CapaianKinerjaExport implements FromView
{
    private $capaianKinerja;
    private $is_template;

    public function __construct(CapaianKinerjaService $capaianKinerja, bool $is_template = false)
    {
        $this->capaianKinerja = $capaianKinerja;
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.capaian-kinerja', ['laporans' => []]);
        }
        return view('excel.template-laporan.capaian-kinerja', [
            'laporans' => $this->capaianKinerja->export(request()->all()),
        ]);
    }
}
