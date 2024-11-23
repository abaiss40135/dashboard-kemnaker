<?php

namespace App\Exports\Sislap\Lapsubjar\Bintibsos;

use App\Services\Sislap\Lapsubjar\Bintibsos\KegiatanSubditbintibsosService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KegiatanSubditbintibsos implements FromView
{
    private bool $is_template;
    private KegiatanSubditbintibsosService $service;

    public function __construct(KegiatanSubditbintibsosService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.kegiatan-subditbintibsos', [
                'laporans' => []
            ]);
        }

        return view('excel.template-laporan.kegiatan-subditbintibsos', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
