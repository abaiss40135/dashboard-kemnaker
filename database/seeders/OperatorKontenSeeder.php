<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class OperatorKontenSeeder extends Seeder
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
                'nrp' => '00110037',
                'email' => 'iqbalhabib261@gmail.com',
                'roles' => [UserSeeder::OPERATOR_KONTEN],
                'password' => '00110037'
            ]
        ];

        foreach($datas as $key => $data){
            $newUser = User::firstOrCreate([
                'nrp' => $data['nrp'],
            ], [
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
            $newUser->roles()->sync($data['roles'] ?? []);
        }
    }
}
