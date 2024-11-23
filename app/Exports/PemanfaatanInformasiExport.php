<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;

class PemanfaatanInformasiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    private $query;
    private int $row_number = 1;

    public function __construct($query) {
        $this->query = $query;
    }

    public function collection(): \Illuminate\Support\Collection {
        return $this->query->get();
    }

    public function headings(): array {
        return [
            'No',
            'Nama',
            'NRP',
            'Polda',
            'Polres',
            'Polsek',
            'Jumlah Konten',
        ];
    }

    public function map($row): array {
        return [
            $this->row_number++,
            $row->pangkat.' '.$row->nama,
            $row->nrp,
            Str::beforeLast($row->satuan1, '-'),
            Str::beforeLast($row->satuan2, '-'),
            Str::beforeLast($row->satuan3, '-'),
            $row->total,
        ];
    }
}
