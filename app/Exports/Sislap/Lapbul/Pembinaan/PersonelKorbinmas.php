<?php

namespace App\Exports\Sislap\Lapbul\Pembinaan;

use App\Services\Sislap\Lapbul\Pembinaan\PersonelKorbinmasService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PersonelKorbinmas implements FromView
{
    private bool $is_template;
    private $service;

    public function __construct(PersonelKorbinmasService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service     = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.personel-korbinmas', ['laporans' => []]);
        }
        return view('excel.template-laporan.personel-korbinmas', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
