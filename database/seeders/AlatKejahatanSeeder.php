<?php

namespace Database\Seeders;

use App\Models\PolisiRW\AlatKejahatan;
use Illuminate\Database\Seeder;

class AlatKejahatanSeeder extends Seeder
{
    public function run(): void
    {
        $datas = ['Petasan', 'Air Soft Gun', 'Panah', 'Senapan Angin', 'Senjata Tajam/Penusuk'];
        foreach ($datas as $key => $data) {
            AlatKejahatan::firstOrCreate(['nama' => $data]);
        }
    }
}
