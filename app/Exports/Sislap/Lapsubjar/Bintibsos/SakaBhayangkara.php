<?php

namespace App\Exports\Sislap\Lapsubjar\Bintibsos;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SakaBhayangkara implements FromView
{
    public function view(): View
    {   
        return view('excel.template-laporan.saka-bhayangkara');
    }
}
