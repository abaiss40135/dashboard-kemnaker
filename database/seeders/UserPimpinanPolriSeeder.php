<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class UserPimpinanPolriSeeder extends Seeder
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
            [  'nrp' =>'72040504', 'email' => '72040504@bos.polri.go.id', 'roles' => [1],  'password' => '72040504' ],
            [  'nrp' =>'69050335', 'email' => '69050335@bos.polri.go.id', 'roles' => [1],  'password' => '69050335' ],
            [  'nrp' =>'65060657', 'email' => '65060657@bos.polri.go.id', 'roles' => [1],  'password' => '65060657' ],
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
