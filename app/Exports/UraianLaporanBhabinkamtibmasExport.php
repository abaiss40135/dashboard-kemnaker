<?php

namespace App\Exports;

use App\Services\Interfaces\LaporanBhabinkamtibmasServiceInterface;
use App\Services\Interfaces\PSNonSengketaServiceInterface;
use App\Services\Interfaces\PSSengketaServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class UraianLaporanBhabinkamtibmasExport implements FromArray, WithMapping, WithHeadings, WithTitle, ShouldAutoSize, ShouldQueue
{
    private int $rowNumber;

    public function __construct(
        private LaporanBhabinkamtibmasServiceInterface $laporanBhabinkamtibmasService,
        private PSSengketaServiceInterface $pSSengketaService,
        private PSNonSengketaServiceInterface $pSNonSengketaService
    ) {
        $this->laporanBhabinkamtibmasService = $laporanBhabinkamtibmasService;
        $this->pSSengketaService = $pSSengketaService;
        $this->pSNonSengketaService = $pSNonSengketaService;
        $this->rowNumber = 0;
    }

    public function array(): array
    {
        $requests = request()->all();

        return [
            ...$this->pSNonSengketaService->export($requests),
            ...$this->pSSengketaService->export($requests),
            ...$this->laporanBhabinkamtibmasService->export($requests)
        ];
    }

    public function map($row): array
    {
        return [
            ++$this->rowNumber,
            $row->nama_personel ?? $row->personel->nama,
            $row->pangkat ?? $row->personel->pangkat,
            $row->nrp ?? $row->user->nrp,
            $row->polda ?? $row->personel?->polda,
            $row->polres ?? $row->personel?->polres,
            $row->polsek ?? $row->personel?->polsek,
            $row->tanggal_laporan ?? $row->created_at->format('Y-m-d H:i:s'),
            $row->jenis_laporan,
            $row->uraian_informasi ?? $row->uraian_kejadian ?? $row->uraian_masalah
        ];
    }

    public function headings(): array
    {
        return [
            'NO.',
            'NAMA',
            'PANGKAT',
            'NRP',
            'POLDA',
            'POLRES',
            'POLSEK',
            'TANGGAL',
            'TIPE LAPORAN',
            'URAIAN INFORMASI'
        ];
    }

    public function title(): string
    {
        return 'Uraian (' . request('start_date') . ' ' . request('end_date') . ')';
    }
}
