<?php

namespace App\Exports\Sislap\Nonlapbul\Lapharvaksinasi;

use App\Services\Sislap\Nonlapbul\LapharVaksinasiService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LapharVaksinasi implements FromView
{
    private $lapharVaksinasiService;
    private $is_template;

    public function __construct(LapharVaksinasiService $lapharVaksinasiService, bool $is_template = false)
    {
        $this->lapharVaksinasiService = $lapharVaksinasiService;
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.laphar-vaksinasi', [
                'laporans' => []
            ]);
        }

        return view('excel.template-laporan.laphar-vaksinasi', [
            'laporans' => $this->lapharVaksinasiService->export(request())
        ]);
    }
}
