<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PimpinanPolriSeeder extends Seeder
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
                'nrp' => '72040504',
                'email' => '72040504@bos.polri.go.id',
                'roles' => [UserSeeder::PIMPINAN_POLRI],
                'password' => '72040504'
            ],
            [
                'nrp' => '69050335',
                'email' => 'SPRIPIMPOLDABANTEN@GMAIL.COM',
                'roles' => [UserSeeder::PIMPINAN_POLRI],
                'password' => '69050335'
            ],
            [
                'nrp' => '65060657',
                'email' => '65060657@bos.polri.go.id',
                'roles' => [UserSeeder::PIMPINAN_POLRI],
                'password' => '65060657'
            ],
            [
                'nrp' => '67110289',
                'email' => '67110289@bos.polri.go.id',
                'roles' => [UserSeeder::PIMPINAN_POLRI],
                'password' => '67110289'
            ],
            [
                'nrp' => '63070908',
                'email' => '63070908@bos.polri.go.id',
                'roles' => [UserSeeder::PIMPINAN_POLRI],
                'password' => '63070908'
            ],
            [
                'nrp' => '74020325',
                'email' => '74020325@bos.polri.go.id',
                'roles' => [UserSeeder::PIMPINAN_POLRI],
                'password' => '74020325'
            ],
                        [
                'nrp' => '68050401',
                'email' => '68050401@bos.polri.go.id',
                'roles' => [UserSeeder::PIMPINAN_POLRI],
                'password' => '68050401'
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
