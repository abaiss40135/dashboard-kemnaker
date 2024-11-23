<?php

namespace App\Exports;

use App\Services\DeteksiDiniService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DeteksiDiniExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldQueue, ShouldAutoSize
{
    private int $rowNumber = 1;
    private int|string $nrp;
    private ?string $date_s, $date_e;

    public function __construct(int|string $nrp, ?string $date_s, ?string $date_e)
    {
        $this->nrp = $nrp;
        $this->date_s = $date_s;
        $this->date_e = $date_e;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return DeteksiDiniService::getByNrp($this->nrp, $this->date_s, $this->date_e);
    }

    public function map($row): array
    {
        $keywordsInformasi = [];
        foreach ($row->laporan_informasi->keywords as $keywords) {
            $keywordsInformasi[] = $keywords->keyword;
        }
        $keywordsInformasi = implode(', ', $keywordsInformasi);

        return [
            $this->rowNumber++,
            $row->nama_narasumber,
            $row->lokasi_mendapatkan_informasi,
            $row->tanggal,
            $row->laporan_informasi->uraian ?? '',
            $keywordsInformasi,
            $row->created_at
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Narasumber',
            'Lokasi Mendapatkan Informasi',
            'Tanggal Kunjungan',
            'Uraian Informasi',
            'Kata Kunci Informasi',
            'Tanggal Laporan',
        ];
    }

    public function title(): string
    {
        return 'Deteksi Dini';
    }
}
