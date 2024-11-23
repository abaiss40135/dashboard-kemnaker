<?php

namespace App\Exports\Sislap\Lapsubjar\Bintibsos;

use App\Services\Sislap\Lapsubjar\Bintibsos\DataJumlahAnggotaService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataJumlahAnggota implements FromView
{
    private $is_template;
    private $dataJumlahAnggotaService;

    public function __construct(DataJumlahAnggotaService $dataJumlahAnggotaService, bool $is_template = false)
    {
        $this->is_template = $is_template;
        $this->dataJumlahAnggotaService = $dataJumlahAnggotaService;
    }

    public function view(): View
    {
        if ($this->is_template) {
            return view('excel.template-laporan.data-jumlah-anggota', ['laporans' =>[]]);
        }

        return view('excel.template-laporan.data-jumlah-anggota', [
            'laporans' => $this->dataJumlahAnggotaService->export(request()->all())
        ]);
    }
}
