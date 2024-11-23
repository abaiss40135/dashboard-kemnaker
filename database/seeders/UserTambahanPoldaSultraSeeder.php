<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaSultraSeeder extends Seeder
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
            [  'nrp' =>'84050558', 'email' => '84050558@bos.polri.go.id', 'roles' => [5],  'password' => '84050558' ],
            [  'nrp' =>'79050848', 'email' => '79050848@bos.polri.go.id', 'roles' => [5],  'password' => '79050848' ],
            [  'nrp' =>'87061526', 'email' => '87061526@bos.polri.go.id', 'roles' => [5],  'password' => '87061526' ],
            [  'nrp' =>'84081024', 'email' => '84081024@bos.polri.go.id', 'roles' => [5],  'password' => '84081024' ],
            [  'nrp' =>'79090822', 'email' => '79090822@bos.polri.go.id', 'roles' => [5],  'password' => '79090822' ],
            [  'nrp' =>'86060077', 'email' => '86060077@bos.polri.go.id', 'roles' => [5],  'password' => '86060077' ],
            [  'nrp' =>'85070262', 'email' => '85070262@bos.polri.go.id', 'roles' => [5],  'password' => '85070262' ],
            [  'nrp' =>'83080002', 'email' => '83080002@bos.polri.go.id', 'roles' => [5],  'password' => '83080002' ],
            [  'nrp' =>'85011158', 'email' => '85011158@bos.polri.go.id', 'roles' => [5],  'password' => '85011158' ],
            [  'nrp' =>'86031876', 'email' => '86031876@bos.polri.go.id', 'roles' => [5],  'password' => '86031876' ],
            [  'nrp' =>'82051134', 'email' => '82051134@bos.polri.go.id', 'roles' => [5],  'password' => '82051134' ],
            [  'nrp' =>'86081782', 'email' => '86081782@bos.polri.go.id', 'roles' => [5],  'password' => '86081782' ],
            [  'nrp' =>'85050365', 'email' => '85050365@bos.polri.go.id', 'roles' => [5],  'password' => '85050365' ],
            [  'nrp' =>'84071176', 'email' => '84071176@bos.polri.go.id', 'roles' => [5],  'password' => '84071176' ],
            [  'nrp' =>'82051418', 'email' => '82051418@bos.polri.go.id', 'roles' => [5],  'password' => '82051418' ],
            [  'nrp' =>'95110561', 'email' => '95110561@bos.polri.go.id', 'roles' => [5],  'password' => '95110561' ],
            [  'nrp' =>'85021283', 'email' => '85021283@bos.polri.go.id', 'roles' => [5],  'password' => '85021283' ],
            [  'nrp' =>'96110307', 'email' => '96110307@bos.polri.go.id', 'roles' => [5],  'password' => '96110307' ],
            [  'nrp' =>'85050166', 'email' => '85050166@bos.polri.go.id', 'roles' => [5],  'password' => '85050166' ],
            [  'nrp' =>'75100873', 'email' => '75100873@bos.polri.go.id', 'roles' => [5],  'password' => '75100873' ],
            [  'nrp' =>'76060925', 'email' => '76060925@bos.polri.go.id', 'roles' => [5],  'password' => '76060925' ],
            [  'nrp' =>'88070937', 'email' => '88070937@bos.polri.go.id', 'roles' => [5],  'password' => '88070937' ],
            [  'nrp' =>'77060953', 'email' => '77060953@bos.polri.go.id', 'roles' => [5],  'password' => '77060953' ],
            [  'nrp' =>'86050555', 'email' => '86050555@bos.polri.go.id', 'roles' => [5],  'password' => '86050555' ],
            [  'nrp' =>'75100846', 'email' => '75100846@bos.polri.go.id', 'roles' => [5],  'password' => '75100846' ],
            [  'nrp' =>'75100846', 'email' => '75100846@bos.polri.go.id', 'roles' => [5],  'password' => '75100846' ],
            [  'nrp' =>'84050558', 'email' => '84050558@bos.polri.go.id', 'roles' => [5],  'password' => '84050558' ],
            [  'nrp' =>'79050848', 'email' => '79050848@bos.polri.go.id', 'roles' => [5],  'password' => '79050848' ],
            [  'nrp' =>'87061526', 'email' => '87061526@bos.polri.go.id', 'roles' => [5],  'password' => '87061526' ],
            [  'nrp' =>'84081024', 'email' => '84081024@bos.polri.go.id', 'roles' => [5],  'password' => '84081024' ],
            [  'nrp' =>'79090822', 'email' => '79090822@bos.polri.go.id', 'roles' => [5],  'password' => '79090822' ],
            [  'nrp' =>'86060077', 'email' => '86060077@bos.polri.go.id', 'roles' => [5],  'password' => '86060077' ],
            [  'nrp' =>'85070262', 'email' => '85070262@bos.polri.go.id', 'roles' => [5],  'password' => '85070262' ],
            [  'nrp' =>'83080002', 'email' => '83080002@bos.polri.go.id', 'roles' => [5],  'password' => '83080002' ],
            [  'nrp' =>'85011158', 'email' => '85011158@bos.polri.go.id', 'roles' => [5],  'password' => '85011158' ],
            [  'nrp' =>'86031876', 'email' => '86031876@bos.polri.go.id', 'roles' => [5],  'password' => '86031876' ],
            [  'nrp' =>'82051134', 'email' => '82051134@bos.polri.go.id', 'roles' => [5],  'password' => '82051134' ],
            [  'nrp' =>'86081782', 'email' => '86081782@bos.polri.go.id', 'roles' => [5],  'password' => '86081782' ],
            [  'nrp' =>'85050365', 'email' => '85050365@bos.polri.go.id', 'roles' => [5],  'password' => '85050365' ],
            [  'nrp' =>'84071176', 'email' => '84071176@bos.polri.go.id', 'roles' => [5],  'password' => '84071176' ],
            [  'nrp' =>'82051418', 'email' => '82051418@bos.polri.go.id', 'roles' => [5],  'password' => '82051418' ],
            [  'nrp' =>'95110561', 'email' => '95110561@bos.polri.go.id', 'roles' => [5],  'password' => '95110561' ],
            [  'nrp' =>'85021283', 'email' => '85021283@bos.polri.go.id', 'roles' => [5],  'password' => '85021283' ],
            [  'nrp' =>'96110307', 'email' => '96110307@bos.polri.go.id', 'roles' => [5],  'password' => '96110307' ],
            [  'nrp' =>'85050166', 'email' => '85050166@bos.polri.go.id', 'roles' => [5],  'password' => '85050166' ],
            [  'nrp' =>'75100873', 'email' => '75100873@bos.polri.go.id', 'roles' => [5],  'password' => '75100873' ],
            [  'nrp' =>'76060925', 'email' => '76060925@bos.polri.go.id', 'roles' => [5],  'password' => '76060925' ],
            [  'nrp' =>'88070937', 'email' => '88070937@bos.polri.go.id', 'roles' => [5],  'password' => '88070937' ],
            [  'nrp' =>'77060953', 'email' => '77060953@bos.polri.go.id', 'roles' => [5],  'password' => '77060953' ],
            [  'nrp' =>'86050555', 'email' => '86050555@bos.polri.go.id', 'roles' => [5],  'password' => '86050555' ],
            [  'nrp' =>'75100846', 'email' => '75100846@bos.polri.go.id', 'roles' => [5],  'password' => '75100846' ],
            [  'nrp' =>'83050491', 'email' => '83050491@bos.polri.go.id', 'roles' => [5],  'password' => '83050491' ],
            [  'nrp' =>'84091263', 'email' => '84091263@bos.polri.go.id', 'roles' => [5],  'password' => '84091263' ],
            [  'nrp' =>'78101040', 'email' => '78101040@bos.polri.go.id', 'roles' => [5],  'password' => '78101040' ],
            [  'nrp' =>'85091497', 'email' => '85091497@bos.polri.go.id', 'roles' => [5],  'password' => '85091497' ],
            [  'nrp' =>'78050688', 'email' => '78050688@bos.polri.go.id', 'roles' => [5],  'password' => '78050688' ],
            [  'nrp' =>'82030501', 'email' => '82030501@bos.polri.go.id', 'roles' => [5],  'password' => '82030501' ],
            [  'nrp' =>'78060985', 'email' => '78060985@bos.polri.go.id', 'roles' => [5],  'password' => '78060985' ],
            [  'nrp' =>'77060753', 'email' => '77060753@bos.polri.go.id', 'roles' => [5],  'password' => '77060753' ],
            [  'nrp' =>'86121747', 'email' => '86121747@bos.polri.go.id', 'roles' => [5],  'password' => '86121747' ],
            [  'nrp' =>'93010749', 'email' => '93010749@bos.polri.go.id', 'roles' => [5],  'password' => '93010749' ],
            [  'nrp' =>'94120746', 'email' => '94120746@bos.polri.go.id', 'roles' => [5],  'password' => '94120746' ],
            [  'nrp' =>'9307050', 'email' => '9307050@bos.polri.go.id', 'roles' => [5],  'password' => '9307050' ],
            [  'nrp' =>'79061388', 'email' => '79061388@bos.polri.go.id', 'roles' => [5],  'password' => '79061388' ],
[  'nrp' =>'83071319', 'email' => '83071319@bos.polri.go.id', 'roles' => [5],  'password' => '83071319' ],
[  'nrp' =>'75110953', 'email' => '75110953@bos.polri.go.id', 'roles' => [5],  'password' => '75110953' ],
[  'nrp' =>'81040560', 'email' => '81040560@bos.polri.go.id', 'roles' => [5],  'password' => '81040560' ],
[  'nrp' =>'88100551', 'email' => '88100551@bos.polri.go.id', 'roles' => [5],  'password' => '88100551' ],
[  'nrp' =>'78011022', 'email' => '78011022@bos.polri.go.id', 'roles' => [5],  'password' => '78011022' ],
[  'nrp' =>'86080800', 'email' => '86080800@bos.polri.go.id', 'roles' => [5],  'password' => '86080800' ],
[  'nrp' =>'78010452', 'email' => '78010452@bos.polri.go.id', 'roles' => [5],  'password' => '78010452' ],
[  'nrp' =>'78100247', 'email' => '78100247@bos.polri.go.id', 'roles' => [5],  'password' => '78100247' ],
[  'nrp' =>'81110043', 'email' => '81110043@bos.polri.go.id', 'roles' => [5],  'password' => '81110043' ],
[  'nrp' =>'84021321', 'email' => '84021321@bos.polri.go.id', 'roles' => [5],  'password' => '84021321' ],
[  'nrp' =>'87071123', 'email' => '87071123@bos.polri.go.id', 'roles' => [5],  'password' => '87071123' ],
[  'nrp' =>'89030574', 'email' => '89030574@bos.polri.go.id', 'roles' => [5],  'password' => '89030574' ],
[  'nrp' =>'89030574', 'email' => '89030574@bos.polri.go.id', 'roles' => [5],  'password' => '89030574' ],
[  'nrp' =>'86011206', 'email' => '86011206@bos.polri.go.id', 'roles' => [5],  'password' => '86011206' ],
[  'nrp' =>'81110331', 'email' => '81110331@bos.polri.go.id', 'roles' => [5],  'password' => '81110331' ],
[  'nrp' =>'830120481', 'email' => '830120481@bos.polri.go.id', 'roles' => [5],  'password' => '830120481' ],
[  'nrp' =>'81030967', 'email' => '81030967@bos.polri.go.id', 'roles' => [5],  'password' => '81030967' ],
[  'nrp' =>'83110208', 'email' => '83110208@bos.polri.go.id', 'roles' => [5],  'password' => '83110208' ],
[  'nrp' =>'78030995', 'email' => '78030995@bos.polri.go.id', 'roles' => [5],  'password' => '78030995' ],
[  'nrp' =>'89090626', 'email' => '89090626@bos.polri.go.id', 'roles' => [5],  'password' => '89090626' ],
[  'nrp' =>'96040019', 'email' => '96040019@bos.polri.go.id', 'roles' => [5],  'password' => '96040019' ],
[  'nrp' =>'83070581', 'email' => '83070581@bos.polri.go.id', 'roles' => [5],  'password' => '83070581' ],
[  'nrp' =>'82061249', 'email' => '82061249@bos.polri.go.id', 'roles' => [5],  'password' => '82061249' ],
[  'nrp' =>'82061249', 'email' => '82061249@bos.polri.go.id', 'roles' => [5],  'password' => '82061249' ],
[  'nrp' =>'78090901', 'email' => '78090901@bos.polri.go.id', 'roles' => [5],  'password' => '78090901' ],
[  'nrp' =>'81110950', 'email' => '81110950@bos.polri.go.id', 'roles' => [5],  'password' => '81110950' ],
[  'nrp' =>'85061108', 'email' => '85061108@bos.polri.go.id', 'roles' => [5],  'password' => '85061108' ],
[  'nrp' =>'88030940', 'email' => '88030940@bos.polri.go.id', 'roles' => [5],  'password' => '88030940' ],
[  'nrp' =>'89080300', 'email' => '89080300@bos.polri.go.id', 'roles' => [5],  'password' => '89080300' ],
[  'nrp' =>'83120849', 'email' => '83120849@bos.polri.go.id', 'roles' => [5],  'password' => '83120849' ],
[  'nrp' =>'84101630', 'email' => '84101630@bos.polri.go.id', 'roles' => [5],  'password' => '84101630' ],
[  'nrp' =>'80120850', 'email' => '80120850@bos.polri.go.id', 'roles' => [5],  'password' => '80120850' ],
[  'nrp' =>'84101630', 'email' => '84101630@bos.polri.go.id', 'roles' => [5],  'password' => '84101630' ],
[  'nrp' =>'82081068', 'email' => '82081068@bos.polri.go.id', 'roles' => [5],  'password' => '82081068' ],
[  'nrp' =>'81110950', 'email' => '81110950@bos.polri.go.id', 'roles' => [5],  'password' => '81110950' ],
[  'nrp' =>'85061108', 'email' => '85061108@bos.polri.go.id', 'roles' => [5],  'password' => '85061108' ],
[  'nrp' =>'88030940', 'email' => '88030940@bos.polri.go.id', 'roles' => [5],  'password' => '88030940' ],
[  'nrp' =>'89120519', 'email' => '89120519@bos.polri.go.id', 'roles' => [5],  'password' => '89120519' ],
[  'nrp' =>'85110313', 'email' => '85110313@bos.polri.go.id', 'roles' => [5],  'password' => '85110313' ],
[  'nrp' =>'87100286', 'email' => '87100286@bos.polri.go.id', 'roles' => [5],  'password' => '87100286' ],
[  'nrp' =>'00020194', 'email' => '00020194@bos.polri.go.id', 'roles' => [5],  'password' => '00020194' ],
[  'nrp' =>'96040763', 'email' => '96040763@bos.polri.go.id', 'roles' => [5],  'password' => '96040763' ],
[  'nrp' =>'82011026', 'email' => '82011026@bos.polri.go.id', 'roles' => [5],  'password' => '82011026' ],
[  'nrp' =>'86121398', 'email' => '86121398@bos.polri.go.id', 'roles' => [5],  'password' => '86121398' ],
[  'nrp' =>'65120649', 'email' => '65120649@bos.polri.go.id', 'roles' => [5],  'password' => '65120649' ],
[  'nrp' =>'89040486', 'email' => '89040486@bos.polri.go.id', 'roles' => [5],  'password' => '89040486' ],

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
