<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaPapuaSeeder extends Seeder
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
            [  'nrp' =>'87061466', 'email' => '87061466@bos.polri.go.id', 'roles' => [5],  'password' => '87061466' ],
[  'nrp' =>'92090693', 'email' => '92090693@bos.polri.go.id', 'roles' => [5],  'password' => '92090693' ],
[  'nrp' =>'78081457', 'email' => '78081457@bos.polri.go.id', 'roles' => [5],  'password' => '78081457' ],
[  'nrp' =>'82081028', 'email' => '82081028@bos.polri.go.id', 'roles' => [5],  'password' => '82081028' ],
[  'nrp' =>'78050677', 'email' => '78050677@bos.polri.go.id', 'roles' => [5],  'password' => '78050677' ],
[  'nrp' =>'84051257', 'email' => '84051257@bos.polri.go.id', 'roles' => [5],  'password' => '84051257' ],
[  'nrp' =>'85111727', 'email' => '85111727@bos.polri.go.id', 'roles' => [5],  'password' => '85111727' ],
[  'nrp' =>'92060706', 'email' => '92060706@bos.polri.go.id', 'roles' => [5],  'password' => '92060706' ],


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
