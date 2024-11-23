<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            'ISLAM',
            'KRISTEN',
            'KATHOLIK',
            'HINDU',
            'BUDHA',
            'KONGHUCU',
        ];

        foreach ($datas as $data) {
            Agama::firstOrCreate(['nama' => $data]);
        }
    }
}
