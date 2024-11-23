<?php

namespace App\Exports;

use App\Services\PSSengketaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PsSengketaExport implements FromCollection, WithHeadings, WithTitle, WithMapping, ShouldQueue, ShouldAutoSize
{
    private $rowNumber = 1;
    private int|string $nrp;
    private ?string $date_s, $date_e;

    public function __construct(int|string $nrp, ?string $date_s, ?string $date_e)
    {
        $this->nrp    = $nrp;
        $this->date_s = $date_s;
        $this->date_e = $date_e;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        return PSSengketaService::getByNrp($this->nrp, $this->date_s, $this->date_e);
    }

    public function map($row): array
    {
        $keywordsKejadian = [];
        if (isset($row->keywords)) foreach ($row->keywords as $keywords) {
            $keywordsKejadian[] = $keywords->keyword;
        }
        $keywordsKejadian = implode(', ', $keywordsKejadian);

        return [
            $this->rowNumber++,
            $row->nama_pihak_1,
            $row->nama_pihak_2,
            $row->tanggal,
            $keywordsKejadian,
            $row->uraian_problem_solving,
            $row->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Pihak 1',
            'Pihak 2',
            'Tanggal Kunjungan',
            'Uraian Kejadian',
            'Kata Kunci Kejadian',
            'Uraian Solusi',
            'Tanggal Laporan',
        ];
    }

    public function title(): string
    {
        return 'PS Sengketa';
    }
}
