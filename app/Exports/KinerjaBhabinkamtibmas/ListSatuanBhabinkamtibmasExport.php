<?php

namespace App\Exports\KinerjaBhabinkamtibmas;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ListSatuanBhabinkamtibmasExport implements ShouldAutoSize, FromCollection, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    public function collection()
    {
        return User::select(
            DB::raw("split_part(personel.satuan1::TEXT, '-', 1) AS polda"),
            DB::raw("split_part(personel.satuan2::TEXT, '-', 1) AS polres"),
            DB::raw("COUNT('user_id') as jumlah")
        )
        ->join('personel', 'personel.user_id', '=', 'users.id')
        ->isBhabinkamtibmas()
        ->whereHas('personel', fn ($personel) => $personel->where('satuan1', 'like', 'POLDA %'))
        ->whereHas('lokasiPenugasans')
        ->groupBy('polres', 'polda')
        ->orderBy('jumlah', 'DESC')
        ->get();
    }

    public function headings(): array
    {
        return [
            'POLDA',
            'POLRES',
            'JUMLAH BHABINKAMTIBMAS',
        ];
    }

    public function map($row): array
    {
        if (empty($row->polres)) {
            return [];
        }

        return [
            $row->polda,
            $row->polres,
            $row->jumlah,
        ];
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Excel Log: '.$exception->getMessage());
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
