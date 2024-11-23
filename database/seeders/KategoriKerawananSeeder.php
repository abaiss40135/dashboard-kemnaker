<?php

namespace Database\Seeders;

use App\Models\PolisiRW\KategoriKerawanan;
use Illuminate\Database\Seeder;

class KategoriKerawananSeeder extends Seeder
{
    public function run(): void
    {
        $datas = ['Kebakaran', 'Pencurian', 'Kecelakaan Lalu Lintas', 'Balapan Liar', 'Narkoba',
            'Kekerasan Terhadap Orang dan Barang', 'KDRT'];
        foreach ($datas as $key => $data) {
            KategoriKerawanan::firstOrCreate(['nama' => $data]);
        }
    }
}
