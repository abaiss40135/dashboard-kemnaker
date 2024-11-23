<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
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
                'nrp' => '77081071',
                'email' => 'asepirpanrosadi99@gmail.com',
                'roles' => [UserSeeder::ADMIN],
                'password' => '77081071'
            ],
            [
                'nrp' => '78030909',
                'email' => 'HPOERNOMO51@YAHOO.CO.ID',
                'roles' => [UserSeeder::ADMIN],
                'password' => '78030909'
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
