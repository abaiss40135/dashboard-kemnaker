<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BhabinkamtibmasLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bhabinkamtibmas = \App\Models\User::isBhabinkamtibmas()->has('lokasiPenugasans')->has('personel')->pluck('id');

        $bhabinkamtibmas->chunk(100)->each(function ($bhabinkabtimas_chunk) {
            foreach ($bhabinkabtimas_chunk as $bhabinkamtibmas_id) {
                \App\Models\Location::updateOrCreate([
                    'user_id' => $bhabinkamtibmas_id,
                ], [
                    'latitude' => rand(-1100000000, 600000000) / 100000000,
                    'longitude' => rand(9400000000, 14100000000) / 100000000
                ]);
            }
        });
    }
}
