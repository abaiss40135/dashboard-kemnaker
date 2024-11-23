<?php

namespace Database\Seeders;

use App\Models\PolisiRW\KategoriKegiatan;
use Illuminate\Database\Seeder;

class KategoriKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $datas = ["Jum'at Curhat", "Sambang Warga", "Problem Solving"];
        foreach ($datas as $key => $data) {
            KategoriKegiatan::firstOrCreate(['nama' => $data]);
        }
    }
}
