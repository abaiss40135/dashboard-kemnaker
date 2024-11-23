<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class OperatorDivHumasSeeder extends Seeder
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
                'email' => 'both-humas@polri.go.id',
                'roles' => [UserSeeder::OPERATOR_DIVHUMAS],
                'password' => '123456789'
            ],
           
        ];
        
        foreach($datas as $key => $data){
            $newUser = User::firstOrCreate([
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);
            $newUser->roles()->sync($data['roles'] ?? []);
        }
    }
}
