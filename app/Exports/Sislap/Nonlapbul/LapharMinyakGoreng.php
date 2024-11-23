<?php

namespace App\Exports\Sislap\Nonlapbul;

use App\Services\Sislap\Nonlapbul\LapharMinyakGorengService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class LapharMinyakGoreng implements FromView
{
    use Exportable;

    private $lapharMinyakGorengService;
    private $is_template;

    public function __construct(bool $is_template = false)
    {
        $this->lapharMinyakGorengService = new LapharMinyakGorengService();
        $this->is_template = $is_template;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.laphar-minyak-goreng', ['laporans' => []]);
        }
        return view('excel.template-laporan.laphar-minyak-goreng', [
            'laporans' => $this->lapharMinyakGorengService->export(request())
        ]);
    }
}
