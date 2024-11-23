<?php

namespace Database\Seeders;

use App\Models\PolisiRW\Pekerjaan;
use Illuminate\Database\Seeder;

class PekerjaanSeeder extends Seeder
{
    public function run(): void
    {
        $datas = [
            'Buruh', 'Pegawai Negeri', 'Pelajar/Mahasiswa', 'Juru Parkir', 'Pegawai Swasta'
        ];
        foreach ($datas as $key => $data) {
            Pekerjaan::firstOrCreate(['name' => $data]);
        }
    }
}
