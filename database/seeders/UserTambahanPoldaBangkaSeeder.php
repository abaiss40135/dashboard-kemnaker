<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaBangkaSeeder extends Seeder
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
            [  'nrp' =>'87051798', 'email' => '87051798@bos.polri.go.id', 'roles' => [5],  'password' => '87051798' ],
            [  'nrp' =>'85121754', 'email' => '85121754@bos.polri.go.id', 'roles' => [5],  'password' => '85121754' ],
            [  'nrp' =>'93050367', 'email' => '93050367@bos.polri.go.id', 'roles' => [5],  'password' => '93050367' ],
            [  'nrp' =>'87051825', 'email' => '87051825@bos.polri.go.id', 'roles' => [5],  'password' => '87051825' ],
            [  'nrp' =>'87101429', 'email' => '87101429@bos.polri.go.id', 'roles' => [5],  'password' => '87101429' ],
            [  'nrp' =>'93050367', 'email' => '93050367@bos.polri.go.id', 'roles' => [5],  'password' => '93050367' ],
            [  'nrp' =>'87051825', 'email' => '87051825@bos.polri.go.id', 'roles' => [5],  'password' => '87051825' ],
            [  'nrp' =>'87101429', 'email' => '87101429@bos.polri.go.id', 'roles' => [5],  'password' => '87101429' ],
            [  'nrp' =>'95120475', 'email' => '95120475@bos.polri.go.id', 'roles' => [5],  'password' => '95120475' ],
            [  'nrp' =>'85101602', 'email' => '85101602@bos.polri.go.id', 'roles' => [5],  'password' => '85101602' ],
            [  'nrp' =>'84040051', 'email' => '84040051@bos.polri.go.id', 'roles' => [5],  'password' => '84040051' ],
            [  'nrp' =>'95070963', 'email' => '95070963@bos.polri.go.id', 'roles' => [5],  'password' => '95070963' ],
            [  'nrp' =>'96080491', 'email' => '96080491@bos.polri.go.id', 'roles' => [5],  'password' => '96080491' ],
            [  'nrp' =>'96080470', 'email' => '96080470@bos.polri.go.id', 'roles' => [5],  'password' => '96080470' ],           
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
