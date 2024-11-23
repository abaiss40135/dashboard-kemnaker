<?php

namespace Database\Seeders;

use App\Models\SatuanKerja;
use Illuminate\Database\Seeder;

class SatuanKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satuan_kerja = [
            [
                'id' => 1,
                'name' => 'SABHARA'
            ],
            [
                'id' => 2,
                'name' => 'INTELKAM'
            ],
            [
                'id' => 3,
                'name' => 'LANTAS'
            ],
            [
                'id' => 4,
                'name' => 'RESKRIM'
            ],
            [
                'id' => 5,
                'name' => 'BINMAS'
            ]
        ];

        foreach($satuan_kerja as $data) {
            SatuanKerja::updateOrCreate(
                ['id' => $data['id']],
                ['name' => $data['name']]
            );
        }
    }
}
