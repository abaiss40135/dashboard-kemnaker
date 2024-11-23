<?php

namespace App\Exports\Sislap\Lapsubjar\Binkamsa;

use App\Services\Sislap\Lapsubjar\Binkamsa\KasusSatpamService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KasusSatpamExport implements FromView
{
    private bool $is_template;
    private $service;

    public function __construct(KasusSatpamService $service, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->service     = $service;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.kasus-satpam', ['laporans' => []]);
        }
        return view('excel.template-laporan.kasus-satpam', [
            'laporans' => $this->service->export(request()->all())
        ]);
    }
}
