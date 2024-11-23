<?php

namespace App\Exports\Sislap\Lapsubjar\Bhabin;

use App\Services\Sislap\Lapsubjar\Bhabin\RekapKegiatanService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapKegiatanExport implements FromView
{
    private bool $is_template;
    private RekapKegiatanService $service;

    public function __construct(RekapKegiatanService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service    = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.rekap-kegiatan', ['laporans' => []]);
        }

        return view('excel.template-laporan.rekap-kegiatan', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
