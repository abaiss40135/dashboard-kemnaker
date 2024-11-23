<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class BhabinkamtibmasPoldaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'nrp' => '75090793',
                'email' => '75090793@bospolri.go.id',
                'roles' => [UserSeeder::OPERATOR_BHABINKAMTIBMAS_POLDA],
                'password' => '75090793'
            ],
        ];

        foreach ($datas as $key => $data) {
            $newUser = User::firstOrCreate([
                'nrp' => $data['nrp'] ?? null,
                'email' => $data['email'],
            ], [
                'password' => bcrypt($data['password'])
            ]);
            $newUser->roles()->sync($data['roles'] ?? []);
        }
    }
}
