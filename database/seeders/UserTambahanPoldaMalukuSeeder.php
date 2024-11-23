<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaMalukuSeeder extends Seeder
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
            [  'nrp' =>'86031818', 'email' => '86031818@bos.polri.go.id', 'roles' => [5],  'password' => '86031818' ],
            [  'nrp' =>'83061117', 'email' => '83061117@bos.polri.go.id', 'roles' => [5],  'password' => '83061117' ],
            [  'nrp' =>'84110518', 'email' => '84110518@bos.polri.go.id', 'roles' => [5],  'password' => '84110518' ],
            [  'nrp' =>'00080190', 'email' => '00080190@bos.polri.go.id', 'roles' => [5],  'password' => '00080190' ],
[  'nrp' =>'96040627', 'email' => '96040627@bos.polri.go.id', 'roles' => [5],  'password' => '96040627' ],
[  'nrp' =>'88010268', 'email' => '88010268@bos.polri.go.id', 'roles' => [5],  'password' => '88010268' ],
[  'nrp' =>'86071717', 'email' => '86071717@bos.polri.go.id', 'roles' => [5],  'password' => '86071717' ],
[  'nrp' =>'96031101', 'email' => '96031101@bos.polri.go.id', 'roles' => [5],  'password' => '96031101' ],
[  'nrp' =>'84031028', 'email' => '84031028@bos.polri.go.id', 'roles' => [5],  'password' => '84031028' ],
[  'nrp' =>'84080712', 'email' => '84080712@bos.polri.go.id', 'roles' => [5],  'password' => '84080712' ],
[  'nrp' =>'96060712', 'email' => '96060712@bos.polri.go.id', 'roles' => [5],  'password' => '96060712' ],
[  'nrp' =>'85120963', 'email' => '85120963@bos.polri.go.id', 'roles' => [5],  'password' => '85120963' ],
[  'nrp' =>'86051384', 'email' => '86051384@bos.polri.go.id', 'roles' => [5],  'password' => '86051384' ],
[  'nrp' =>'85101518', 'email' => '85101518@bos.polri.go.id', 'roles' => [5],  'password' => '85101518' ],
[  'nrp' =>'86090819', 'email' => '86090819@bos.polri.go.id', 'roles' => [5],  'password' => '86090819' ],
[  'nrp' =>'84121049', 'email' => '84121049@bos.polri.go.id', 'roles' => [5],  'password' => '84121049' ],
[  'nrp' =>'84080947', 'email' => '84080947@bos.polri.go.id', 'roles' => [5],  'password' => '84080947' ],
[  'nrp' =>'86040518', 'email' => '86040518@bos.polri.go.id', 'roles' => [5],  'password' => '86040518' ],
[  'nrp' =>'85101199', 'email' => '85101199@bos.polri.go.id', 'roles' => [5],  'password' => '85101199' ],
[  'nrp' =>'77110241', 'email' => '77110241@bos.polri.go.id', 'roles' => [5],  'password' => '77110241' ],
[  'nrp' =>'85050817', 'email' => '85050817@bos.polri.go.id', 'roles' => [5],  'password' => '85050817' ],
[  'nrp' =>'85020644', 'email' => '85020644@bos.polri.go.id', 'roles' => [5],  'password' => '85020644' ],
[  'nrp' =>'85050800', 'email' => '85050800@bos.polri.go.id', 'roles' => [5],  'password' => '85050800' ],
[  'nrp' =>'85060717', 'email' => '85060717@bos.polri.go.id', 'roles' => [5],  'password' => '85060717' ],
[  'nrp' =>'82110918', 'email' => '82110918@bos.polri.go.id', 'roles' => [5],  'password' => '82110918' ],
[  'nrp' =>'84030514', 'email' => '84030514@bos.polri.go.id', 'roles' => [5],  'password' => '84030514' ],
[  'nrp' =>'85031665', 'email' => '85031665@bos.polri.go.id', 'roles' => [5],  'password' => '85031665' ],
[  'nrp' =>'83011001', 'email' => '83011001@bos.polri.go.id', 'roles' => [5],  'password' => '83011001' ],
[  'nrp' =>'93030941', 'email' => '93030941@bos.polri.go.id', 'roles' => [5],  'password' => '93030941' ],
[  'nrp' =>'83080032', 'email' => '83080032@bos.polri.go.id', 'roles' => [5],  'password' => '83080032' ],
[  'nrp' =>'85091584', 'email' => '85091584@bos.polri.go.id', 'roles' => [5],  'password' => '85091584' ],
[  'nrp' =>'87120115', 'email' => '87120115@bos.polri.go.id', 'roles' => [5],  'password' => '87120115' ],
[  'nrp' =>'85121577', 'email' => '85121577@bos.polri.go.id', 'roles' => [5],  'password' => '85121577' ],
[  'nrp' =>'82031168', 'email' => '82031168@bos.polri.go.id', 'roles' => [5],  'password' => '82031168' ],
[  'nrp' =>'96060721', 'email' => '96060721@bos.polri.go.id', 'roles' => [5],  'password' => '96060721' ],
[  'nrp' =>'85011282', 'email' => '85011282@bos.polri.go.id', 'roles' => [5],  'password' => '85011282' ],
[  'nrp' =>'85060710', 'email' => '85060710@bos.polri.go.id', 'roles' => [5],  'password' => '85060710' ],
[  'nrp' =>'84030705', 'email' => '84030705@bos.polri.go.id', 'roles' => [5],  'password' => '84030705' ],
[  'nrp' =>'77090906', 'email' => '77090906@bos.polri.go.id', 'roles' => [5],  'password' => '77090906' ],
[  'nrp' =>'87050961', 'email' => '87050961@bos.polri.go.id', 'roles' => [5],  'password' => '87050961' ],
[  'nrp' =>'84051268', 'email' => '84051268@bos.polri.go.id', 'roles' => [5],  'password' => '84051268' ],
[  'nrp' =>'85120962', 'email' => '85120962@bos.polri.go.id', 'roles' => [5],  'password' => '85120962' ],
[  'nrp' =>'84080713', 'email' => '84080713@bos.polri.go.id', 'roles' => [5],  'password' => '84080713' ],
[  'nrp' =>'86040618', 'email' => '86040618@bos.polri.go.id', 'roles' => [5],  'password' => '86040618' ],
[  'nrp' =>'86121326', 'email' => '86121326@bos.polri.go.id', 'roles' => [5],  'password' => '86121326' ],
[  'nrp' =>'87070726', 'email' => '87070726@bos.polri.go.id', 'roles' => [5],  'password' => '87070726' ],
[  'nrp' =>'86120709', 'email' => '86120709@bos.polri.go.id', 'roles' => [5],  'password' => '86120709' ],
[  'nrp' =>'85080369', 'email' => '85080369@bos.polri.go.id', 'roles' => [5],  'password' => '85080369' ],
[  'nrp' =>'89040464', 'email' => '89040464@bos.polri.go.id', 'roles' => [5],  'password' => '89040464' ],
[  'nrp' =>'87070493', 'email' => '87070493@bos.polri.go.id', 'roles' => [5],  'password' => '87070493' ],
[  'nrp' =>'85010599', 'email' => '85010599@bos.polri.go.id', 'roles' => [5],  'password' => '85010599' ],
[  'nrp' =>'85050315', 'email' => '85050315@bos.polri.go.id', 'roles' => [5],  'password' => '85050315' ],
[  'nrp' =>'86051750', 'email' => '86051750@bos.polri.go.id', 'roles' => [5],  'password' => '86051750' ],
[  'nrp' =>'89090680', 'email' => '89090680@bos.polri.go.id', 'roles' => [5],  'password' => '89090680' ],
[  'nrp' =>'82011013', 'email' => '82011013@bos.polri.go.id', 'roles' => [5],  'password' => '82011013' ],
[  'nrp' =>'94120238', 'email' => '94120238@bos.polri.go.id', 'roles' => [5],  'password' => '94120238' ],
[  'nrp' =>'86120724', 'email' => '86120724@bos.polri.go.id', 'roles' => [5],  'password' => '86120724' ],
[  'nrp' =>'83051305', 'email' => '83051305@bos.polri.go.id', 'roles' => [5],  'password' => '83051305' ],
[  'nrp' =>'84020200', 'email' => '84020200@bos.polri.go.id', 'roles' => [5],  'password' => '84020200' ],
[  'nrp' =>'84061735', 'email' => '84061735@bos.polri.go.id', 'roles' => [5],  'password' => '84061735' ],
[  'nrp' =>'82110949', 'email' => '82110949@bos.polri.go.id', 'roles' => [5],  'password' => '82110949' ],
[  'nrp' =>'87030064', 'email' => '87030064@bos.polri.go.id', 'roles' => [5],  'password' => '87030064' ],
[  'nrp' =>'83050606', 'email' => '83050606@bos.polri.go.id', 'roles' => [5],  'password' => '83050606' ],
[  'nrp' =>'64050003', 'email' => '64050003@bos.polri.go.id', 'roles' => [5],  'password' => '64050003' ],
[  'nrp' =>'84100458', 'email' => '84100458@bos.polri.go.id', 'roles' => [5],  'password' => '84100458' ],
[  'nrp' =>'94061111', 'email' => '94061111@bos.polri.go.id', 'roles' => [5],  'password' => '94061111' ],
[  'nrp' =>'83030659', 'email' => '83030659@bos.polri.go.id', 'roles' => [5],  'password' => '83030659' ],
[  'nrp' =>'83090132', 'email' => '83090132@bos.polri.go.id', 'roles' => [5],  'password' => '83090132' ],
[  'nrp' =>'84120903', 'email' => '84120903@bos.polri.go.id', 'roles' => [5],  'password' => '84120903' ],
[  'nrp' =>'99090433', 'email' => '99090433@bos.polri.go.id', 'roles' => [5],  'password' => '99090433' ],
[  'nrp' =>'96010992', 'email' => '96010992@bos.polri.go.id', 'roles' => [5],  'password' => '96010992' ],
[  'nrp' =>'85031828', 'email' => '85031828@bos.polri.go.id', 'roles' => [5],  'password' => '85031828' ],
[  'nrp' =>'95071008', 'email' => '95071008@bos.polri.go.id', 'roles' => [5],  'password' => '95071008' ],
[  'nrp' =>'93040818', 'email' => '93040818@bos.polri.go.id', 'roles' => [5],  'password' => '93040818' ],
[  'nrp' =>'94129238', 'email' => '94129238@bos.polri.go.id', 'roles' => [5],  'password' => '94129238' ],
[  'nrp' =>'90010328', 'email' => '90010328@bos.polri.go.id', 'roles' => [5],  'password' => '90010328' ],
[  'nrp' =>'82120470', 'email' => '82120470@bos.polri.go.id', 'roles' => [5],  'password' => '82120470' ],
[  'nrp' =>'84070049', 'email' => '84070049@bos.polri.go.id', 'roles' => [5],  'password' => '84070049' ],
[  'nrp' =>'83091191', 'email' => '83091191@bos.polri.go.id', 'roles' => [5],  'password' => '83091191' ],
[  'nrp' =>'76040690', 'email' => '76040690@bos.polri.go.id', 'roles' => [5],  'password' => '76040690' ],
[  'nrp' =>'01010142', 'email' => '01010142@bos.polri.go.id', 'roles' => [5],  'password' => '01010142' ],
[  'nrp' =>'85010535', 'email' => '85010535@bos.polri.go.id', 'roles' => [5],  'password' => '85010535' ],
[  'nrp' =>'87060403', 'email' => '87060403@bos.polri.go.id', 'roles' => [5],  'password' => '87060403' ],
[  'nrp' =>'76120683', 'email' => '76120683@bos.polri.go.id', 'roles' => [5],  'password' => '76120683' ],
[  'nrp' =>'00060420', 'email' => '00060420@bos.polri.go.id', 'roles' => [5],  'password' => '00060420' ],
[  'nrp' =>'91010250', 'email' => '91010250@bos.polri.go.id', 'roles' => [5],  'password' => '91010250' ],
[  'nrp' =>'85111466', 'email' => '85111466@bos.polri.go.id', 'roles' => [5],  'password' => '85111466' ],
[  'nrp' =>'95050889', 'email' => '95050889@bos.polri.go.id', 'roles' => [5],  'password' => '95050889' ],
[  'nrp' =>'97120569', 'email' => '97120569@bos.polri.go.id', 'roles' => [5],  'password' => '97120569' ],
[  'nrp' =>'88120003', 'email' => '88120003@bos.polri.go.id', 'roles' => [5],  'password' => '88120003' ],
[  'nrp' =>'97010040', 'email' => '97010040@bos.polri.go.id', 'roles' => [5],  'password' => '97010040' ],
[  'nrp' =>'88020388', 'email' => '88020388@bos.polri.go.id', 'roles' => [5],  'password' => '88020388' ],
[  'nrp' =>'83011057', 'email' => '83011057@bos.polri.go.id', 'roles' => [5],  'password' => '83011057' ],
[  'nrp' =>'94050661', 'email' => '94050661@bos.polri.go.id', 'roles' => [5],  'password' => '94050661' ],
[  'nrp' =>'87010870', 'email' => '87010870@bos.polri.go.id', 'roles' => [5],  'password' => '87010870' ],
[  'nrp' =>'94120283', 'email' => '94120283@bos.polri.go.id', 'roles' => [5],  'password' => '94120283' ],
[  'nrp' =>'94120855', 'email' => '94120855@bos.polri.go.id', 'roles' => [5],  'password' => '94120855' ],
[  'nrp' =>'76090677', 'email' => '76090677@bos.polri.go.id', 'roles' => [5],  'password' => '76090677' ],
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
