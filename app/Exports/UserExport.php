<?php

namespace App\Exports;

use App\Helpers\Constants;
use App\Services\Interfaces\BUJPServiceInterface;
use App\Services\Interfaces\RiwayatSioServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\RiwayatSioService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class UserExport implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize, ShouldQueue
{

    /**
     * @var int
     */
    private $rowNumber;
    /**
     * @var RiwayatSioServiceInterface
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService  = $userService;
        $this->rowNumber    = 0;
    }

    public function collection()
    {
        return $this->userService->export(request()->all());
    }

    public function map($row): array
    {
        return [
            ++$this->rowNumber,
            $this->userService->getNamaAttribute($row),
            $row->nrp ?? $row->email,
            $row?->personel?->pangkat ?? "-",
            $row?->personel?->polda ?? "-",
            $row?->personel?->jabatan ?? "-",
            $this->userService->getNoHandphoneAttribute($row),
            $row->last_login_at ?? 'Belum Login',
            implode(PHP_EOL, $row->roles->pluck('alias')->toArray())
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            "Nama",
            'NRP/Email',
            "Pangkat",
            "Polda",
            "Jabatan",
            "No. Telepon",
            'Login Terakhir',
            'Hak Akses',
        ];
    }

    public function title(): string
    {
        return 'User '  . config('app.name');
    }
}
