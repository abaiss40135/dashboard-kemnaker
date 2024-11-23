<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas;

use App\Services\Sislap\Lapsubjar\Binpolmas\DataPokdarkamtibmasService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataPokdarkamtibmasExport implements FromView
{
    private bool $is_template;
    private DataPokdarkamtibmasService $service;

    public function __construct(DataPokdarkamtibmasService $service, bool $is_template = false) {
        $this->is_template = $is_template;
        $this->service = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-pokdarkamtibmas', ['laporans' => []]);
        }
        return view('excel.template-laporan.data-pokdarkamtibmas', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
