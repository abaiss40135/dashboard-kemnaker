<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserLatihanPoldaSeeder extends Seeder
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
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-aceh@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-sumut@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-sumbar@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-riau@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-kepri@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-jambi@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-bengkulu@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-sumsel@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-kep-babel@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-lampung@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-pmj@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-banten@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-jabar@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-jateng@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-diy@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-jatim@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-kalbar@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-kalteng@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-kalsel@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-kaltim@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-kaltara@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-sulut@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-gorontalo@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-sulteng@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-sulbar@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-sulsel@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-sulsel2@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-sultra@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-sultra2@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-bali@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-ntb@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-ntt@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-malut@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-maluku@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-papbar@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-papua@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
            [  'nrp' =>'', 'email' => 'bhabinkamtibmas-polda-jatim2@polri.go.id', 'roles' => [5],  'password' => 'bhabinkamtibmas' ],
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
