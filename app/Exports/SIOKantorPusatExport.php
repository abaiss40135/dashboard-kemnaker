<?php

namespace App\Exports;

use App\Helpers\Constants;
use App\Services\Interfaces\BUJPServiceInterface;
use App\Services\Interfaces\RiwayatSioServiceInterface;
use App\Services\RiwayatSioService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SIOKantorPusatExport implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize, ShouldQueue
{

    /**
     * @var int
     */
    private $rowNumber;
    /**
     * @var RiwayatSioServiceInterface
     */
    private $riwayatSIOService;

    public function __construct(RiwayatSioServiceInterface $riwayatSIOService)
    {
        $this->riwayatSIOService  = $riwayatSIOService;
        $this->rowNumber    = 0;
    }

    public function collection()
    {
        return $this->riwayatSIOService->export(request()->all());
    }

    public function map($row): array
    {
        $isValid = $row->dokumens->pluck('validasi')->toArray();
        return [
            ++$this->rowNumber,
            $row->polda,
            request('is_terbit') ? $row->status_terakhir->created_at : $row->tanggal_pengajuan,
            $row->checklist->id_proyek ?? "",
            $row->checklist->id_izin ?? "",
            $row->checklist->nib->nama_perseroan ?? "",
            $row->checklist->nib->email_perusahaan ?? "",
            $row->checklist->bidang_spesifik ?? "",
            !isset($row->status_terakhir) ? "Belum Melengkapi Dokumen" : $row->status_terakhir->statusSio->id . ". " .strip_tags($row->status_terakhir->statusSio->status),
            in_array(null, $isValid) ? 'Belum Diverifikasi' : (in_array(false, $isValid) ? 'Tidak Valid' : 'Valid'),
            is_null($row->status_audit) ? 'Belum Dijadwalkan' : Constants::STATUS_AUDIT[$row->status_audit],
//            (isset($sio->status_terakhir) && $sio->status_terakhir->status_sio_id === 6) ? "Terbit" : "Belum Terbit"
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Polda',
            request('is_terbit') ? 'Tanggal Terbit' : 'Tanggal Pengajuan',
            'Nomor Proyek',
            'ID Izin',
            'Nama BUJP',
            'Email',
            'Jenis Usaha',
            'Status Pengajuan',
            'Status Dokumen',
            'Status Audit',
//            'Status Penerbitan',
        ];
    }

    public function title(): string
    {
        return 'SIO Kantor Pusat';
    }
}
