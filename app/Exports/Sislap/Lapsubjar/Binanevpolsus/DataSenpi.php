<?php

namespace App\Exports\Sislap\Lapsubjar\Binanevpolsus;

use App\Services\Sislap\Lapsubjar\Binanevpolsus\DataSenpiService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DataSenpi implements FromView
{
    private bool $is_template;
    private $service;

    public function __construct(DataSenpiService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if($this->is_template) {
            return view('excel.template-laporan.data-senpi', ['laporans' => []]);
        }

        return view('excel.template-laporan.data-senpi', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
