<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KommasKbppExport implements FromView
{
    public function view(): View
    {
        return view('excel.template-laporan.kommas-kbpp');
    }
}
