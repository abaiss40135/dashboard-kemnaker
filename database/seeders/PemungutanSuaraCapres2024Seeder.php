<?php

namespace Database\Seeders;

use App\Models\Laporan\ProgramPemerintah\PemungutanSuaraCapres2024;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Database\Seeder;

class PemungutanSuaraCapres2024Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//         for 2000x times and chunk it
        for($i = 1; $i <= 2000; $i++) {
            // get random user_id with bhabinkamtibmas role
            $user_id = User::whereHas('roles', function ($query) {
                $query->whereIn('id', [5]);
            })->has('personel')->inRandomOrder()->first()->id;

            $provinsi = Provinsi::inRandomOrder()->first();
            $kabupaten = $provinsi->kota()->inRandomOrder()->first();
            $kecamatan = $kabupaten->kecamatans()->inRandomOrder()->first();
            $kelurahan = $kecamatan->desas()->inRandomOrder()->first();

            $data = [
                'user_id' => $user_id,
                'suara_capres_1' => rand(10, 450),
                'suara_capres_2' => rand(10, 500),
                'suara_capres_3' => rand(10, 400),
                'suara_tidak_sah' => rand(0, 200),
                'provinsi_kode' => $provinsi->code,
                'kabupaten_kode' => $kabupaten->code,
                'kecamatan_kode' => $kecamatan->code,
                'kelurahan_kode' => $kelurahan->code,
                'uraian_hasil_suara' => 'Suara capres 1: ' . rand(0, 100) . ', Suara capres 2: ' . rand(0, 100) . ', Suara capres 3: ' . rand(0, 100) . ', Suara tidak sah: ' . rand(0, 100)
            ];

            PemungutanSuaraCapres2024::create($data);
        }
    }
}
