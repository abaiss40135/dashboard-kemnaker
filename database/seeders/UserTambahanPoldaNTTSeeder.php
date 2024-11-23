<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaNTTSeeder extends Seeder
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
            [  'nrp' =>'86120494', 'email' => '86120494@bos.polri.go.id', 'roles' => [5],  'password' => '86120494' ],
            [  'nrp' =>'86010661', 'email' => '86010661@bos.polri.go.id', 'roles' => [5],  'password' => '86010661' ],
[  'nrp' =>'85121309', 'email' => '85121309@bos.polri.go.id', 'roles' => [5],  'password' => '85121309' ],
[  'nrp' =>'94050685', 'email' => '94050685@bos.polri.go.id', 'roles' => [5],  'password' => '94050685' ],
[  'nrp' =>'85030962', 'email' => '85030962@bos.polri.go.id', 'roles' => [5],  'password' => '85030962' ],
[  'nrp' =>'85060281', 'email' => '85060281@bos.polri.go.id', 'roles' => [5],  'password' => '85060281' ],
[  'nrp' =>'86031500', 'email' => '86031500@bos.polri.go.id', 'roles' => [5],  'password' => '86031500' ],
[  'nrp' =>'86100816', 'email' => '86100816@bos.polri.go.id', 'roles' => [5],  'password' => '86100816' ],
[  'nrp' =>'79031322', 'email' => '79031322@bos.polri.go.id', 'roles' => [5],  'password' => '79031322' ],
[  'nrp' =>'83050978', 'email' => '83050978@bos.polri.go.id', 'roles' => [5],  'password' => '83050978' ],
[  'nrp' =>'88070301', 'email' => '88070301@bos.polri.go.id', 'roles' => [5],  'password' => '88070301' ],
[  'nrp' =>'91070226', 'email' => '91070226@bos.polri.go.id', 'roles' => [5],  'password' => '91070226' ],
[  'nrp' =>'00070308', 'email' => '00070308@bos.polri.go.id', 'roles' => [5],  'password' => '00070308' ],
[  'nrp' =>'99030404', 'email' => '99030404@bos.polri.go.id', 'roles' => [5],  'password' => '99030404' ],
[  'nrp' =>'00040109', 'email' => '00040109@bos.polri.go.id', 'roles' => [5],  'password' => '00040109' ],
[  'nrp' =>'97020395', 'email' => '97020395@bos.polri.go.id', 'roles' => [5],  'password' => '97020395' ],
[  'nrp' =>'86090553', 'email' => '86090553@bos.polri.go.id', 'roles' => [5],  'password' => '86090553' ],
[  'nrp' =>'86050326', 'email' => '86050326@bos.polri.go.id', 'roles' => [5],  'password' => '86050326' ],
[  'nrp' =>'83120790', 'email' => '83120790@bos.polri.go.id', 'roles' => [5],  'password' => '83120790' ],
[  'nrp' =>'87100338', 'email' => '87100338@bos.polri.go.id', 'roles' => [5],  'password' => '87100338' ],
[  'nrp' =>'84031401', 'email' => '84031401@bos.polri.go.id', 'roles' => [5],  'password' => '84031401' ],
[  'nrp' =>'82021172', 'email' => '82021172@bos.polri.go.id', 'roles' => [5],  'password' => '82021172' ],
[  'nrp' =>'83111049', 'email' => '83111049@bos.polri.go.id', 'roles' => [5],  'password' => '83111049' ],
[  'nrp' =>'80020916', 'email' => '80020916@bos.polri.go.id', 'roles' => [5],  'password' => '80020916' ],
[  'nrp' =>'84020768', 'email' => '84020768@bos.polri.go.id', 'roles' => [5],  'password' => '84020768' ],
[  'nrp' =>'95030050', 'email' => '95030050@bos.polri.go.id', 'roles' => [5],  'password' => '95030050' ],
[  'nrp' =>'85071377', 'email' => '85071377@bos.polri.go.id', 'roles' => [5],  'password' => '85071377' ],
[  'nrp' =>'87050964', 'email' => '87050964@bos.polri.go.id', 'roles' => [5],  'password' => '87050964' ],
[  'nrp' =>'86090553', 'email' => '86090553@bos.polri.go.id', 'roles' => [5],  'password' => '86090553' ],
[  'nrp' =>'86050326', 'email' => '86050326@bos.polri.go.id', 'roles' => [5],  'password' => '86050326' ],
[  'nrp' =>'83120790', 'email' => '83120790@bos.polri.go.id', 'roles' => [5],  'password' => '83120790' ],
[  'nrp' =>'87100338', 'email' => '87100338@bos.polri.go.id', 'roles' => [5],  'password' => '87100338' ],
[  'nrp' =>'84031401', 'email' => '84031401@bos.polri.go.id', 'roles' => [5],  'password' => '84031401' ],
[  'nrp' =>'82021172', 'email' => '82021172@bos.polri.go.id', 'roles' => [5],  'password' => '82021172' ],
[  'nrp' =>'83111049', 'email' => '83111049@bos.polri.go.id', 'roles' => [5],  'password' => '83111049' ],
[  'nrp' =>'80020916', 'email' => '80020916@bos.polri.go.id', 'roles' => [5],  'password' => '80020916' ],
[  'nrp' =>'84020768', 'email' => '84020768@bos.polri.go.id', 'roles' => [5],  'password' => '84020768' ],
[  'nrp' =>'95030050', 'email' => '95030050@bos.polri.go.id', 'roles' => [5],  'password' => '95030050' ],
[  'nrp' =>'85071377', 'email' => '85071377@bos.polri.go.id', 'roles' => [5],  'password' => '85071377' ],
[  'nrp' =>'87050964', 'email' => '87050964@bos.polri.go.id', 'roles' => [5],  'password' => '87050964' ],
[  'nrp' =>'92070246', 'email' => '92070246@bos.polri.go.id', 'roles' => [5],  'password' => '92070246' ],
[  'nrp' =>'84020705', 'email' => '84020705@bos.polri.go.id', 'roles' => [5],  'password' => '84020705' ],
[  'nrp' =>'82081203', 'email' => '82081203@bos.polri.go.id', 'roles' => [5],  'password' => '82081203' ],
[  'nrp' =>'86091728', 'email' => '86091728@bos.polri.go.id', 'roles' => [5],  'password' => '86091728' ],
[  'nrp' =>'82010769', 'email' => '82010769@bos.polri.go.id', 'roles' => [5],  'password' => '82010769' ],
[  'nrp' =>'89100537', 'email' => '89100537@bos.polri.go.id', 'roles' => [5],  'password' => '89100537' ],
[  'nrp' =>'89100253', 'email' => '89100253@bos.polri.go.id', 'roles' => [5],  'password' => '89100253' ],
[  'nrp' =>'91110005', 'email' => '91110005@bos.polri.go.id', 'roles' => [5],  'password' => '91110005' ],
[  'nrp' =>'87051118', 'email' => '87051118@bos.polri.go.id', 'roles' => [5],  'password' => '87051118' ],
[  'nrp' =>'84120494', 'email' => '84120494@bos.polri.go.id', 'roles' => [5],  'password' => '84120494' ],
[  'nrp' =>'84041741', 'email' => '84041741@bos.polri.go.id', 'roles' => [5],  'password' => '84041741' ],
[  'nrp' =>'82091201', 'email' => '82091201@bos.polri.go.id', 'roles' => [5],  'password' => '82091201' ],
[  'nrp' =>'86031671', 'email' => '86031671@bos.polri.go.id', 'roles' => [5],  'password' => '86031671' ],
[  'nrp' =>'83061099', 'email' => '83061099@bos.polri.go.id', 'roles' => [5],  'password' => '83061099' ],
[  'nrp' =>'87011178', 'email' => '87011178@bos.polri.go.id', 'roles' => [5],  'password' => '87011178' ],
[  'nrp' =>'78080699', 'email' => '78080699@bos.polri.go.id', 'roles' => [5],  'password' => '78080699' ],


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
