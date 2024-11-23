<?php

namespace App\Exports;

use App\Services\Interfaces\BUJPServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class BujpExport implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize, ShouldQueue
{
    /**
     * @var BUJPServiceInterface
     */
    private $bujpService;
    /**
     * @var int
     */
    private $rowNumber;

    public function __construct(BUJPServiceInterface $BUJPService)
    {
        $this->bujpService  = $BUJPService;
        $this->rowNumber    = 0;
    }

    public function collection()
    {
        return $this->bujpService->export(request()->all());
    }

    public function map($row): array
    {
        return [
            ++$this->rowNumber,
            $row->nama_badan_usaha,
            empty($row->nib) ? "" : "'".$row->nib,
            $row->tipe_badan_usaha,
            Str::title($row->detail_alamat . ', ' . $row->provinsi . ', ' . $row->kabupaten . ', ' . $row->kecamatan . ', ' . $row->desa),
            $row->nomor_telepon,
            $row->email,
            "'".$row->npwp_badan_usaha,
            str_replace(',', PHP_EOL, Str::title($row->bidang_usaha)),
            $row->satpams_count ?? 0,
            $row->nama_penanggung_jawab,
            $row->jabatan_penanggung_jawab,
            $row->nomor_telepon_penanggung_jawab,
            "'".$row->nomor_ktp_penanggung_jawab,
            $row->last_login_at
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama BUJP',
            'NIB',
            'Tipe Badan Usaha',
            'Alamat',
            'No Telepon',
            'Email',
            'NPWP',
            'Bidang Usaha',
            'Jumlah Satpam',
            'Nama Penanggung Jawab',
            'Jabatan Penanggung Jawab',
            'No. Telp Penanggung Jawab',
            'No. KTP Penanggung Jawab',
            'Terakhir Login'
        ];
    }

    public function title(): string
    {
        return 'Ekspor BUJP';
    }
}
