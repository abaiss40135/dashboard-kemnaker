<?php

namespace App\Exports\Sislap\Lapsubjar\Komsatpam;

use App\Services\Sislap\Lapsubjar\Komsatpam\DataSatpamService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataSatpam implements FromView
{
    private $is_template;
    private $dataSatpamService;

    public function __construct(DataSatpamService $dataSatpamService, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->dataSatpamService = $dataSatpamService;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-satpam', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-satpam', [
            'laporans' => $this->dataSatpamService->export(request()->all()),
        ]);
    }
}
