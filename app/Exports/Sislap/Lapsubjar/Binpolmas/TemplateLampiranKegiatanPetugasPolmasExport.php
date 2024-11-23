<?php

namespace App\Exports\Sislap\Lapsubjar\Binpolmas;

use Maatwebsite\Excel\Concerns\{
    Exportable,
    ShouldAutoSize,
    FromView,
    WithEvents,
    WithStrictNullComparison
};
use Maatwebsite\Excel\Events\AfterSheet;

class TemplateLampiranKegiatanPetugasPolmasExport implements
    ShouldAutoSize,
    WithStrictNullComparison,
    FromView,
    WithEvents
{
    use Exportable;

    const BASE_TABLE = [
        'No',
        'Nama Polisi RW',
        'Pangkat/NRP'
    ];

    const SAMBANG_TABLE = [
        ...self::BASE_TABLE,
        'Nama yang Dikunjungi',
        'Tanggal Sambang',
        'Alamat yang Dikunjungi',
    ];

    const PEMECAHAN_MASALAH_TABLE = [
        ...self::BASE_TABLE,
        'Jenis Permasalahan',
        'Tanggal Permasalahan',
        'Tempat Permasalahan',
        'Tindak Lanjut',
    ];

    const LAPORAN_INFORMASI_TABLE = [
        ...self::BASE_TABLE,
        'Nama Sumber Informasi',
        'Tanggal Informasi',
        'Tempat Informasi',
        'Uraian Informasi',
    ];

    const PERKARA_RINGAN_TABLE = [
        ...self::BASE_TABLE,
        'Jenis Perkara Ringan',
        'Tanggal Perkara Ringan',
        'Tempat Perkara Ringan',
        'Tindak Lanjut'
    ];

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('excel.template-laporan.binpolmas.template-lampiran-kegiatan-petugas-polmas', [
            'first'  => self::SAMBANG_TABLE,
            'second' => self::PEMECAHAN_MASALAH_TABLE,
            'third'  => self::LAPORAN_INFORMASI_TABLE,
            'fourth' => self::PERKARA_RINGAN_TABLE,
        ]);
    }

    public function registerEvents(): array
    {
        $row_headings = [1, 4, 7, 10];

        $style = [
            'font' => [
                'bold' => true,
                'size' => '12',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        return [
            AfterSheet::class => function (AfterSheet $event) use ($row_headings, $style) {
                foreach ($row_headings as $row) {
                    $event->sheet->getDelegate()->getStyle('A' . $row . ':G' . $row)->applyFromArray($style);
                }
            }
        ];
    }
}