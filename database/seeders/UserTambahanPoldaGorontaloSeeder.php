<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaGorontaloSeeder extends Seeder
{
    const ADMIN = 1;
    const OPERATOR_KONTEN = 2;
    const OPERATOR_MABES = 3;
    const OPERATOR_POLDA = 4;
    const BHABIN = 5;
    const BUJP = 6;
    const SATPAM = 7;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [  'nrp' =>'92010148', 'email' => '92010148@bos.polri.go.id', 'roles' => [5],  'password' => '92010148' ],
            [  'nrp' =>'84090655', 'email' => '84090655@bos.polri.go.id', 'roles' => [5],  'password' => '84090655' ],
            [  'nrp' =>'94020835', 'email' => '94020835@bos.polri.go.id', 'roles' => [5],  'password' => '94020835' ],
            [  'nrp' =>'84071711', 'email' => '84071711@bos.polri.go.id', 'roles' => [5],  'password' => '84071711' ],
            [  'nrp' =>'86090174', 'email' => '86090174@bos.polri.go.id', 'roles' => [5],  'password' => '86090174' ],
[  'nrp' =>'94020412', 'email' => '94020412@bos.polri.go.id', 'roles' => [5],  'password' => '94020412' ],
[  'nrp' =>'87010169', 'email' => '87010169@bos.polri.go.id', 'roles' => [5],  'password' => '87010169' ],
[  'nrp' =>'82080949', 'email' => '82080949@bos.polri.go.id', 'roles' => [5],  'password' => '82080949' ],


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
