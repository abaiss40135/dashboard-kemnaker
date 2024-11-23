<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class OperatorMabes2Seeder extends Seeder
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
                'nrp' => '74010357',
                'email' => '74010357@gmail.com',
                'roles' => [UserSeeder::OPERATOR_MABES_2],
                'password' => '74010357'
            ], [
                'nrp' => '01090121',
                'email' => '01090121@gmail.com',
                'roles' => [UserSeeder::OPERATOR_MABES_2],
                'password' => '01090121'
            ],

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
