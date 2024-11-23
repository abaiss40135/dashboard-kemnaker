<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class OperatorPoldaSeeder extends Seeder
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
                'nrp' => '80101300',
                'email' => '80101300@gmail.com',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '80101300'
            ], [
                'nrp' => '87030857', // aceh
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '87030857'
            ], [
                'nrp' => '96080705', // babel
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '96080705'
            ], [
                'nrp' => '84111023', // sumatera barat
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '84111023'
            ], [
                'nrp' => '86091152', // sumatera barat
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '86091152'
            ], [
                'nrp' => '94030842', // kepulauan riau
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '94030842'
            ], [
                'nrp' => '80060391', // riau
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '80060391'
            ], [
                'nrp' => '87081573', // jawa tengah
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '87081573'
            ], [
                'nrp' => '84091046', // jawa timur
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '84091046'
            ], [
                'nrp' => '94010909', // jawa timur
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '94010909'
            ], [
                'nrp' => '98010214', // bali
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '98010214'
            ], [
                'nrp' => '76120451', // bengkulu
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '76120451'
            ], [
                'nrp' => '82110087', // bengkulu
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '82110087'
            ], [
                'nrp' => '88100383', // bengkulu
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '88100383'
            ], [
                'nrp' => '84050635', // kalimantan barat
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '84050635'
            ], [
                'nrp' => '97120238', // kalimantan barat
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '97120238'
            ], [
                'nrp' => '77100655', // kalimantan selatan
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '77100655'
            ], [
                'nrp' => '73050577', // kalimantan utara
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '73050577'
            ], [
                'nrp' => '94100657', // kalimantan utara
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '94100657'
            ], [
                'nrp' => '96010498', // kalimantan utara
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '96010498'
            ], [
                'nrp' => '94100657', // kalimantan utara
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '94100657'
            ], [
                'nrp' => '81070913', // kalimantan timur
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '81070913'
            ], [
                'nrp' => '99020018', // kalimantan timur
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '99020018'
            ], [
                'nrp' => '88110466', // kalimantan timur
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '88110466'
            ], [
                'nrp' => '90080287', // nusa tenggara timur
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '90080287'
            ], [
                'nrp' => '89010362', // nusa tenggara barat
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '89010362'
            ], [
                'nrp' => '81070979', // papua
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '81070979'
            ], [
                'nrp' => '97020265', // papua barat
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '97020265'
            ], [
                'nrp' => '00010490', // papua barat
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '00010490'
            ], [
                'nrp' => '94030234', // banten
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '94030234'
            ], [
                'nrp' => '90030145', // metro jaya
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '90030145'
            ], [
                'nrp' => '84120229', // sulteng
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '84120229'
            ], [
                'nrp' => '95040790', // sumatera utara
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '95040790'
            ], [
                'nrp' => '76120596', // jabar
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '76120596'
            ], [
                'nrp' => '94081113', // daerah istimewa yogyakarta
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '94081113'
            ], [
                'nrp' => '97030286', // jambi
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '97030286'
            ], [
                'nrp' => '98030415', // sulawesi barat
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '98030415'
            ], [
                'nrp' => '83050223', // sulawesi selatan
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '83050223'
            ], [
                'nrp' => '84120229', // sulawesi tengah
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '84120229'
            ], [
                'nrp' => '81041289', // sulawesi tenggara
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '81041289'
            ], [
                'nrp' => '75020417', // sulawesi tenggara
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '75020417'
            ], [
                'nrp' => '88041112', // sulawesi utara
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '88041112'
            ], [
                'nrp' => '86120526', // sumatera selatan
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '86120526'
            ], [
                'nrp' => '95090017', // kalimantan tengah
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '95090017'
            ], [
                'nrp' => '92120935', // gorontalo
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '92120935'
            ], [
                'nrp' => '197505132014121000', // lampung
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '197505132014121000'
            ], [
                'nrp' => '94051104', // maluku utara
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '94051104'
            ], [
                'nrp' => '82090904', // maluku
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '82090904'
            ], [
                'nrp' => '80101300', // sumatera utara
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '80101300'
            ], [
                'nrp' => '82081122', // lampung
                'email' => '',
                'roles' => [UserSeeder::OPERATOR_POLDA],
                'password' => '82081122'
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
