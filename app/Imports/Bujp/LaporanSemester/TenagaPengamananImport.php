<?php

namespace App\Imports\Bujp\LaporanSemester;

use App\Http\Traits\SweetAlertTrait;
use App\Models\Bujp;
use App\Models\Bujp\LaporanSemester\TenagaPengamanan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class TenagaPengamananImport implements ToCollection, WithStartRow, WithHeadingRow
{
    use SweetAlertTrait;
    public function __construct()
    {
        HeadingRowFormatter::extend('custom', function($value, $key) {
            return match($key) {
                1 => 'tanggal_sio',
                2 => 'no_sio',
                3 => 'pengguna_jasa',
                4 => 'kualifikasi_gp',
                5 => 'kualifikasi_gm',
                6 => 'kualifikasi_gu',
                7 => 'perumahan',
                8 => 'hotel',
                9 => 'rumah_sakit',
                10 => 'perbankan',
                11 => 'pabrik',
                12 => 'toko',
                13 => 'perkebunan',
                14 => 'tambang',
                15 => 'kantor',
                16 => 'transportasi',
                17 => 'pendidikan',
                default => $value,
            };
        });

        HeadingRowFormatter::default('custom');
    }

    public function startRow(): int
    {
        return 3;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        try {
            DB::beginTransaction();
            $collection->map(function($item) {
                unset($item['No']);
                $item['user_id'] = auth()->id();

                $item['bujp_id'] = auth()->user()->bujp?->id;

                $date = \DateTime::createFromFormat('d/m/Y', str_replace(["\n", "\r", "\x1a"], '', $item['tanggal_sio']));
                if(!is_bool($date)) {
                    $item['tanggal_sio'] = $date->format('Y-m-d');
                } else {
                    $item['tanggal_sio'] = date('Y-m-d', mktime(0, 0, 0, 1, $item['tanggal_sio'] - 1, 1900));
                }

                if($item['bujp_id'] === null) {
                    throw new \Exception('Data BUJP di akun milik anda tidak terbaca oleh sistem!');
                }

                TenagaPengamanan::create($item->toArray());
            });
            DB::commit();
            $this->flashSuccess('Berhasil mengimport data laporan semester tenaga pengamanan!');
        } catch(\Exception $e) {
            DB::rollBack();
            $this->flashError('Terjadi Kesalahan!<br>' . $e->getMessage());
        }
    }
}
