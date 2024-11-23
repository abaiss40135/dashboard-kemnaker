<?php

namespace Database\Seeders;

use App\Models\Instansi;
use Illuminate\Database\Seeder;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = collect([
            'Kementerian Kelautan Perikanan', //kkp
            'Kementerian Lingkungan Hidup dan Kehutanan', //klhk
            'Kementerian Hukum dan HAM', //kemkuham,
            'Kementerian Pendidikan Budaya dan Riset Teknologi', //kemdikbudristek
            'Kementerian Pertanian',
            'Kementerian Perhubungan',
            'Perum Perhutani',
            'PT KAI Persero',
            'Dinas Pemprov/Pemkab/Pemkot'
        ]);

        $collection->each(function($instansi) {
            Instansi::create([
                'instansi' => $instansi
            ]);
        });
    }
}
