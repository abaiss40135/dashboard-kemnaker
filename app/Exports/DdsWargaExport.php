<?php

namespace App\Exports;

use App\Services\DDSWargaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DdsWargaExport implements FromCollection, WithTitle, WithHeadings, WithMapping, ShouldQueue, ShouldAutoSize
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
        return DDSWargaService::getByNrp($this->nrp, $this->date_s, $this->date_e);
    }

    public function map($row): array
    {
        $keywordsInformasi = [];
        foreach ($row->laporan_informasi->keywords as $keywords) {
            $keywordsInformasi[] = $keywords->keyword;
        }
        $keywordsInformasi = implode(', ', $keywordsInformasi);

        $keywordsPendapat = [];
        if (isset($row->pendapat_warga)) foreach ($row->pendapat_warga[0]->keywords as $keywords) {
            $keywordsPendapat[] = $keywords->keyword;
        }
        $keywordsPendapat = implode(', ', $keywordsPendapat);

        return [
            $this->rowNumber++,
            $row->nama_kepala_keluarga,
            $row->pendapat_warga ? $row->pendapat_warga[0]->jenis_pendapat : '',
            $row->pendapat_warga ? $row->pendapat_warga[0]->uraian : '',
            $keywordsPendapat,
            $row->nama_penerima_kunjungan,
            $row->tanggal,
            $row->provinsi_kepala_keluarga
            . ', ' . $row->kabupaten_kepala_keluarga
            . ', ' . $row->kecamatan_kepala_keluarga
            . ', ' . $row->desa_kepala_keluarga
            . ', ' . $row->detail_alamat_kepala_keluarga,
            $row->laporan_informasi->uraian ?? '',
            $keywordsInformasi,
            $row->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kepala Keluarga',
            'Jenis Pendapat Warga',
            'Uraian Pendapat Warga',
            'Kata Kunci Pendapat Warga',
            'Penerima Kunjungan',
            'Tanggal Kunjungan',
            'Alamat',
            'Uraian Informasi',
            'Kata Kunci Informasi',
            'Tanggal Laporan'
        ];
    }

    public function title(): string
    {
        return 'DDS Warga';
    }
}
