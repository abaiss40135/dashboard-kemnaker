<?php

namespace Database\Seeders;

use App\Models\Suku;
use Illuminate\Database\Seeder;

class SukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            'JAWA',
            'BATAK',
            'DAYAK',
            'ASMAT',
            'MINAHASA',
            'MELAYU',
            'SUNDA',
            'MADURA',
            'BETAWI',
            'BUGIS'
        ];

        foreach ($datas as $data) {
            Suku::firstOrCreate(['nama' => $data]);
        }
    }
}
