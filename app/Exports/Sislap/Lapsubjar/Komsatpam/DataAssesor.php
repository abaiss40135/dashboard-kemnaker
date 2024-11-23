<?php

namespace App\Exports\Sislap\Lapsubjar\Komsatpam;

use App\Services\Sislap\Lapsubjar\Komsatpam\DataAssesorService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataAssesor implements FromView
{
    private $is_template;
    private $dataAssesorService;

    public function __construct(DataAssesorService $dataAssesorService, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->dataAssesorService = $dataAssesorService;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-assesor', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-assesor', [
            'laporans' => $this->dataAssesorService->export(request()->all())
        ]);
    }
}
