<?php

namespace App\Exports;

use App\Services\Interfaces\SatpamServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SatpamExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, ShouldQueue
{
    /**
     * @var SatpamServiceInterface
     */
    private $satpamService;
    /**
     * @var int
     */
    private $rowNumber;

    public function __construct(SatpamServiceInterface $satpamService)
    {
        $this->satpamService = $satpamService;
        $this->rowNumber    = 0;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->satpamService->exportList(request()->all());
    }

    public function headings(): array
    {
        return [
            "No",
            "Nama Satpam",
            "No KTA Satpam",
            "No Registrasi Satpam",
            "Tanggal Terbit KTA Satpam",
            "No KTP Satpam",
            "Jenis Satpam",
            "Nama BUJP",
            "Lokasi Penugasan",
            "Nomor HP",
            "Tempat, Tanggal Lahir Satpam",
            "Alamat Satpam",
            "Terakhir Login"
        ];
    }

    public function map($row): array
    {
        return [
            ++$this->rowNumber,
            $row->nama,
            "'".$row->no_kta,
            $row->no_reg,
            $row->tanggal_terbit_kta,
            "'".$row->no_ktp,
            empty($row->bujp_id) ? 'Organik' : "Outsourcing",
            $row->nama_badan_usaha ?? "Non BUJP",
            $row->tempat_tugas,
            "'".$row->no_hp,
            $row->tempat_lahir . "," . $row->tanggal_lahir,
            $row->detail_alamat ." (". $row->desa .", ". $row->kecamatan .", ". $row->kabupaten .", ". $row->provinsi .")",
            $row->last_login_at
        ];
    }
}
