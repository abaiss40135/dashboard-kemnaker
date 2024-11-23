<?php

namespace App\Exports\PemungutanSuaraCapres;

use App\Models\Provinsi;
use App\Services\DashboardSuaraCapres2024Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DataSheet implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize
{
    private $provinsi;
    private $service;
    private $rowNumber;

    public function __construct($provinsi_kode, DashboardSuaraCapres2024Service $service)
    {
        $queryProv = Provinsi::where('code', $provinsi_kode)->first();
        $this->provinsi = $queryProv->name;

        $this->service = $service;
        $this->rowNumber = 0;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->service->akumulasiSuaraPerKabupatenKota($this->provinsi);
    }

    public function headings(): array
    {
        return [
            'No',
            'Kabupaten/Kota',
            'Suara Capres 1',
            'Suara Capres 2',
            'Suara Capres 3',
            'Suara Tidak Sah',
            'Total Seluruh Suara',
        ];
    }

    public function title(): string
    {
        return $this->provinsi;
    }

    public function map($row): array
    {
        return [
            ++$this->rowNumber,
            $row->kabupaten,
            $row->total_suara_01,
            $row->total_suara_02,
            $row->total_suara_03,
            $row->total_suara_tidak_sah,
            $row->total_seluruh_suara,
        ];
    }
}
