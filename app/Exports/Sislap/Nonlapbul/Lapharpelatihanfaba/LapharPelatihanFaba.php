<?php

namespace App\Exports\Sislap\Nonlapbul\Lapharpelatihanfaba;

use App\Services\Sislap\Nonlapbul\LapharPelatihanFabaService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LapharPelatihanFaba implements FromView
{
    private $LapharPelatihanFabaService;
    private $is_template;

    public function __construct(LapharPelatihanFabaService $LapharPelatihanFabaService, bool $is_template = false)
    {
        $this->LapharPelatihanFabaService = $LapharPelatihanFabaService;
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-pelatihan-faba', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-pelatihan-faba', [
            'laporans' => $this->LapharPelatihanFabaService->export(request())
        ]);
    }
}
