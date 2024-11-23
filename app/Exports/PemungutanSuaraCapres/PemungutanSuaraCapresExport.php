<?php

namespace App\Exports\PemungutanSuaraCapres;

use App\Exports\InvoicesPerMonthSheet;
use App\Models\Laporan\ProgramPemerintah\PemungutanSuaraCapres2024;
use App\Services\DashboardSuaraCapres2024Service;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PemungutanSuaraCapresExport implements WithMultipleSheets
{
    use Exportable;

    private $service;

    public function __construct(DashboardSuaraCapres2024Service $service)
    {
        $this->service = $service;
    }

    public function sheets(): array
    {
        $listProv = PemungutanSuaraCapres2024::select('provinsi_kode')->groupBy('provinsi_kode')
            ->orderBy('provinsi_kode')->get()->pluck('provinsi_kode');

        $sheets = [];

        foreach ($listProv as $prov) {
            $sheets[] = new DataSheet($prov, $this->service);
        }

        return $sheets;
    }
}
