<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class OperatorBagopsnalevSeeder extends Seeder
{
    public function run()
    {
        $polres = [
            "role_id"   => \App\Models\User::BAGOPSNALEV_POLRES,
            "nrp"       => "76060273",
            "email"     => "widiastutiririh@gmail.com"

        ];
        $polda = [
            "role_id"   => \App\Models\User::BAGOPSNALEV_POLDA,
            "nrp"       => "65010039",
            "email"     => "TUDYS98@GMAIL.COM"

        ];
        $mabes = [
            "role_id"   => \App\Models\User::BAGOPSNALEV_MABES,
            "nrp"       => "95081277",
            "email"     => "dimas.dbp@gmail.com"
        ];

        foreach (array_merge([$mabes, $polda, $polres]) as $akun) {
            $newUser = User::firstOrCreate([
                'nrp' => $akun['nrp'],
                'email' => $akun['email'],
            ], [
                'password' => bcrypt($akun['nrp'])
            ]);
            $newUser->roles()->sync([$akun['role_id']]);
        }
    }
}
