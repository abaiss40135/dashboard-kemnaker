<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class OperatorMabesSeeder extends Seeder
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
                'email' => '74010357@bospolri.go.id',
                'roles' => [UserSeeder::OPERATOR_MABES],
                'password' => '74010357'
            ],
            [
                'nrp' => '01090121',
                'email' => 'naldiyansa789@gmail.com',
                'roles' => [UserSeeder::OPERATOR_MABES],
                'password' => '01090121'
            ],
            [
                'nrp' => '85100694',
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_MABES],
                'password' => '85100694'
            ],
            [
                'nrp' => '90090028',
                'email' => 'naritisari6@gmail.com',
                'roles' => [UserSeeder::OPERATOR_MABES],
                'password' => '90090028'
            ],
            [
                'nrp' => '01020243',
                'email' => 'rizalanwar0302@gmail.com',
                'roles' => [UserSeeder::OPERATOR_MABES],
                'password' => '01020243'
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
