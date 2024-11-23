<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    const ADMIN             = 1;
    const OPERATOR_KONTEN   = 2;
    const OPERATOR_MABES    = 3;
    const OPERATOR_POLDA    = 4;
    const BHABIN            = 5;
    const BUJP              = 6;
    const SATPAM            = 7;
    const PUBLIK            = 8;
    const PIMPINAN_POLRI    = 9;
    const BHABINKAMTIBMAS_PENSIUN    = 10;
    const OPERATOR_DIVHUMAS = 12;
    const OPERATOR_BHABINKAMTIBMAS_POLDA    = 11;
    const OPERATOR_MABES_2  = 15;
    const BHABINKAMTIBMAS_MUTASI  = 17;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'user_id' => 1,
                'email' => 'bujp@bospolri.go.id',
                'roles' => [6],
                'password' => 'bujp'
            ],
            [
                'user_id' => 2,
                'email' => 'bhabin@bospolri.go.id',
                'roles' => [5],
                'password' => 'bhabin'
            ],
            [
                'user_id' => 3,
                'email' => 'admin@bospolri.go.id',
                'roles' => [1],
                'password' => 'admin'
            ],
            [
                'user_id' => 4,
                'email' => 'operator@bospolri.go.id',
                'roles' => [2],
                'password' => 'operator'
            ],
            [
                'user_id' => 5,
                'email' => 'satpam@bospolri.go.id',
                'roles' => [7],
                'password' => 'satpam'
            ],

            [
                'user_id' => 7,
                'email' => 'julianto@brainmatics.com',
                'roles' => [7],
                'password' => 'julianto'
            ],
            [
                'user_id' => 8,
                'email' => 'aldi@brainmatics.com',
                'roles' => [7],
                'password' => 'aldi'
            ],
            [
                'user_id' => 9,
                'email' => 'aziz@gmail.com',
                'roles' => [7],
                'password' => 'aziz'
            ],
            [
                'user_id' => 10,
                'email' => 'satria@gmail.com',
                'roles' => [7],
                'password' => 'satria'
            ],
            [
                'user_id' => 11,
                'email' => 'haris@jdt.com',
                'roles' => [7],
                'password' => 'haris'
            ],
            [
                'user_id' => 12,
                'email' => 'aditya@brainmatics.com',
                'roles' => [7],
                'password' => 'aditya'
            ],
            [
                'user_id' => 13,
                'email' => 'rudi@brainmatics.com',
                'roles' => [7],
                'password' => 'rudi'
            ],
            [
                'user_id' => 14,
                'email' => 'jamal@brainmatics.com',
                'roles' => [7],
                'password' => 'jamal'
            ],
            [
                'user_id' => 15,
                'nrp' => '00110037',
                'email' => 'operator@bospolri.go.id',
                'roles' => [self::OPERATOR_KONTEN],
                'password' => 'iqbal1311'
            ],
            [
                'email' => 'bhabinkamtibmas@polri.go.id',
                'roles' => [self::BHABIN],
                'password' => 'bhabinkamtibmas'
            ],
            [
                'email' => 'bujp@polri.go.id',
                'roles' => [self::BUJP],
                'password' => 'bujp'
            ],
            [
                'email' => 'satpam@polri.go.id',
                'roles' => [self::SATPAM],
                'password' => 'satpam'
            ],
            [
                'email' => 'admin@polri.go.id',
                'roles' => [self::ADMIN],
                'password' => 'admin'
            ],
            [
                'nrp' => '64070228',
                'email' => '64070228@polri.go.id',
                'roles' => [self::ADMIN],
                'password' => '64070228'
            ],
            [
                'nrp' => '63070908',
                'email' => '63070908@polri.go.id',
                'roles' => [self::ADMIN],
                'password' => '63070908'
            ],


        ];

//        DB::table('users')->truncate();
//        DB::table('role_user')->truncate();

        foreach($datas as $key => $data){
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
