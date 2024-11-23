<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaLampungSeeder extends Seeder
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
            [  'nrp' =>'81030539', 'email' => '81030539@bos.polri.go.id', 'roles' => [5],  'password' => '81030539' ],
            [  'nrp' =>'88110391', 'email' => '88110391@bos.polri.go.id', 'roles' => [5],  'password' => '88110391' ],
            [  'nrp' =>'86061593', 'email' => '86061593@bos.polri.go.id', 'roles' => [5],  'password' => '86061593' ],
            [  'nrp' =>'86060043', 'email' => '86060043@bos.polri.go.id', 'roles' => [5],  'password' => '86060043' ],
            [  'nrp' =>'82040672', 'email' => '82040672@bos.polri.go.id', 'roles' => [5],  'password' => '82040672' ],
            [  'nrp' =>'81061355', 'email' => '81061355@bos.polri.go.id', 'roles' => [5],  'password' => '81061355' ],
            [  'nrp' =>'87020216', 'email' => '87020216@bos.polri.go.id', 'roles' => [5],  'password' => '87020216' ],
            [  'nrp' =>'87060222', 'email' => '87060222@bos.polri.go.id', 'roles' => [5],  'password' => '87060222' ],
            [  'nrp' =>'85091435', 'email' => '85091435@bos.polri.go.id', 'roles' => [5],  'password' => '85091435' ],
            [  'nrp' =>'84100713', 'email' => '84100713@bos.polri.go.id', 'roles' => [5],  'password' => '84100713' ],
            [  'nrp' =>'87021185', 'email' => '87021185@bos.polri.go.id', 'roles' => [5],  'password' => '87021185' ],
[  'nrp' =>'94040380', 'email' => '94040380@bos.polri.go.id', 'roles' => [5],  'password' => '94040380' ],
[  'nrp' =>'79070830', 'email' => '79070830@bos.polri.go.id', 'roles' => [5],  'password' => '79070830' ],
[  'nrp' =>'81061355', 'email' => '81061355@bos.polri.go.id', 'roles' => [5],  'password' => '81061355' ],
[  'nrp' =>'89090063', 'email' => '89090063@bos.polri.go.id', 'roles' => [5],  'password' => '89090063' ],
[  'nrp' =>'85101959', 'email' => '85101959@bos.polri.go.id', 'roles' => [5],  'password' => '85101959' ],
[  'nrp' =>'83060095', 'email' => '83060095@bos.polri.go.id', 'roles' => [5],  'password' => '83060095' ],
[  'nrp' =>'89030186', 'email' => '89030186@bos.polri.go.id', 'roles' => [5],  'password' => '89030186' ],
[  'nrp' =>'77030459', 'email' => '77030459@bos.polri.go.id', 'roles' => [5],  'password' => '77030459' ],
[  'nrp' =>'87040402', 'email' => '87040402@bos.polri.go.id', 'roles' => [5],  'password' => '87040402' ],
[  'nrp' =>'82100824', 'email' => '82100824@bos.polri.go.id', 'roles' => [5],  'password' => '82100824' ],
[  'nrp' =>'89090190', 'email' => '89090190@bos.polri.go.id', 'roles' => [5],  'password' => '89090190' ],
[  'nrp' =>'87071017', 'email' => '87071017@bos.polri.go.id', 'roles' => [5],  'password' => '87071017' ],
[  'nrp' =>'95010446', 'email' => '95010446@bos.polri.go.id', 'roles' => [5],  'password' => '95010446' ],
[  'nrp' =>'84061634', 'email' => '84061634@bos.polri.go.id', 'roles' => [5],  'password' => '84061634' ],
[  'nrp' =>'76100942', 'email' => '76100942@bos.polri.go.id', 'roles' => [5],  'password' => '76100942' ],
[  'nrp' =>'88041013', 'email' => '88041013@bos.polri.go.id', 'roles' => [5],  'password' => '88041013' ],
[  'nrp' =>'78081517', 'email' => '78081517@bos.polri.go.id', 'roles' => [5],  'password' => '78081517' ],
[  'nrp' =>'93120201', 'email' => '93120201@bos.polri.go.id', 'roles' => [5],  'password' => '93120201' ],
[  'nrp' =>'94020538', 'email' => '94020538@bos.polri.go.id', 'roles' => [5],  'password' => '94020538' ],
[  'nrp' =>'65110490', 'email' => '65110490@bos.polri.go.id', 'roles' => [5],  'password' => '65110490' ],
[  'nrp' =>'85070848', 'email' => '85070848@bos.polri.go.id', 'roles' => [5],  'password' => '85070848' ],
[  'nrp' =>'85070848', 'email' => '85070848@bos.polri.go.id', 'roles' => [5],  'password' => '85070848' ],
[  'nrp' =>'64010622', 'email' => '64010622@bos.polri.go.id', 'roles' => [5],  'password' => '64010622' ],
[  'nrp' =>'85011246', 'email' => '85011246@bos.polri.go.id', 'roles' => [5],  'password' => '85011246' ],
[  'nrp' =>'88120032', 'email' => '88120032@bos.polri.go.id', 'roles' => [5],  'password' => '88120032' ],
[  'nrp' =>'85100384', 'email' => '85100384@bos.polri.go.id', 'roles' => [5],  'password' => '85100384' ],
[  'nrp' =>'89070369', 'email' => '89070369@bos.polri.go.id', 'roles' => [5],  'password' => '89070369' ],
[  'nrp' =>'64120082', 'email' => '64120082@bos.polri.go.id', 'roles' => [5],  'password' => '64120082' ],
[  'nrp' =>'87080608', 'email' => '87080608@bos.polri.go.id', 'roles' => [5],  'password' => '87080608' ],
[  'nrp' =>'95010754', 'email' => '95010754@bos.polri.go.id', 'roles' => [5],  'password' => '95010754' ],
[  'nrp' =>'73090586', 'email' => '73090586@bos.polri.go.id', 'roles' => [5],  'password' => '73090586' ],
[  'nrp' =>'82030857', 'email' => '82030857@bos.polri.go.id', 'roles' => [5],  'password' => '82030857' ],
[  'nrp' =>'84030362', 'email' => '84030362@bos.polri.go.id', 'roles' => [5],  'password' => '84030362' ],
[  'nrp' =>'78100592', 'email' => '78100592@bos.polri.go.id', 'roles' => [5],  'password' => '78100592' ],
[  'nrp' =>'86011245', 'email' => '86011245@bos.polri.go.id', 'roles' => [5],  'password' => '86011245' ],
[  'nrp' =>'85110679', 'email' => '85110679@bos.polri.go.id', 'roles' => [5],  'password' => '85110679' ],
[  'nrp' =>'71070328', 'email' => '71070328@bos.polri.go.id', 'roles' => [5],  'password' => '71070328' ],
[  'nrp' =>'86120198', 'email' => '86120198@bos.polri.go.id', 'roles' => [5],  'password' => '86120198' ],
[  'nrp' =>'73050233', 'email' => '73050233@bos.polri.go.id', 'roles' => [5],  'password' => '73050233' ],
[  'nrp' =>'86040576', 'email' => '86040576@bos.polri.go.id', 'roles' => [5],  'password' => '86040576' ],
[  'nrp' =>'93090612', 'email' => '93090612@bos.polri.go.id', 'roles' => [5],  'password' => '93090612' ],
[  'nrp' =>'85100389', 'email' => '85100389@bos.polri.go.id', 'roles' => [5],  'password' => '85100389' ],
[  'nrp' =>'89090322', 'email' => '89090322@bos.polri.go.id', 'roles' => [5],  'password' => '89090322' ],
[  'nrp' =>'86020434', 'email' => '86020434@bos.polri.go.id', 'roles' => [5],  'password' => '86020434' ],
[  'nrp' =>'93070963', 'email' => '93070963@bos.polri.go.id', 'roles' => [5],  'password' => '93070963' ],
[  'nrp' =>'91110336', 'email' => '91110336@bos.polri.go.id', 'roles' => [5],  'password' => '91110336' ],
[  'nrp' =>'97080537', 'email' => '97080537@bos.polri.go.id', 'roles' => [5],  'password' => '97080537' ],
[  'nrp' =>'67050469', 'email' => '67050469@bos.polri.go.id', 'roles' => [5],  'password' => '67050469' ],
[  'nrp' =>'87120620', 'email' => '87120620@bos.polri.go.id', 'roles' => [5],  'password' => '87120620' ],
[  'nrp' =>'85050385', 'email' => '85050385@bos.polri.go.id', 'roles' => [5],  'password' => '85050385' ],
[  'nrp' =>'79100437', 'email' => '79100437@bos.polri.go.id', 'roles' => [5],  'password' => '79100437' ],
[  'nrp' =>'87090738', 'email' => '87090738@bos.polri.go.id', 'roles' => [5],  'password' => '87090738' ],
[  'nrp' =>'82120132', 'email' => '82120132@bos.polri.go.id', 'roles' => [5],  'password' => '82120132' ],
[  'nrp' =>'93090977', 'email' => '93090977@bos.polri.go.id', 'roles' => [5],  'password' => '93090977' ],
[  'nrp' =>'83050622', 'email' => '83050622@bos.polri.go.id', 'roles' => [5],  'password' => '83050622' ],
[  'nrp' =>'95060082', 'email' => '95060082@bos.polri.go.id', 'roles' => [5],  'password' => '95060082' ],
[  'nrp' =>'91110336', 'email' => '91110336@bos.polri.go.id', 'roles' => [5],  'password' => '91110336' ],
[  'nrp' =>'97080537', 'email' => '97080537@bos.polri.go.id', 'roles' => [5],  'password' => '97080537' ],
[  'nrp' =>'67050469', 'email' => '67050469@bos.polri.go.id', 'roles' => [5],  'password' => '67050469' ],
[  'nrp' =>'87120620', 'email' => '87120620@bos.polri.go.id', 'roles' => [5],  'password' => '87120620' ],
[  'nrp' =>'85050385', 'email' => '85050385@bos.polri.go.id', 'roles' => [5],  'password' => '85050385' ],
[  'nrp' =>'84050216', 'email' => '84050216@bos.polri.go.id', 'roles' => [5],  'password' => '84050216' ],
[  'nrp' =>'94100074', 'email' => '94100074@bos.polri.go.id', 'roles' => [5],  'password' => '94100074' ],
[  'nrp' =>'85070850', 'email' => '85070850@bos.polri.go.id', 'roles' => [5],  'password' => '85070850' ],
[  'nrp' =>'83030084', 'email' => '83030084@bos.polri.go.id', 'roles' => [5],  'password' => '83030084' ],
[  'nrp' =>'84051398', 'email' => '84051398@bos.polri.go.id', 'roles' => [5],  'password' => '84051398' ],
[  'nrp' =>'87010416', 'email' => '87010416@bos.polri.go.id', 'roles' => [5],  'password' => '87010416' ],
[  'nrp' =>'86071194', 'email' => '86071194@bos.polri.go.id', 'roles' => [5],  'password' => '86071194' ],
[  'nrp' =>'96071072', 'email' => '96071072@bos.polri.go.id', 'roles' => [5],  'password' => '96071072' ],
[  'nrp' =>'98080151', 'email' => '98080151@bos.polri.go.id', 'roles' => [5],  'password' => '98080151' ],
[  'nrp' =>'84101087', 'email' => '84101087@bos.polri.go.id', 'roles' => [5],  'password' => '84101087' ],
[  'nrp' =>'94071110', 'email' => '94071110@bos.polri.go.id', 'roles' => [5],  'password' => '94071110' ],
[  'nrp' =>'00020163', 'email' => '00020163@bos.polri.go.id', 'roles' => [5],  'password' => '00020163' ],
[  'nrp' =>'82010689', 'email' => '82010689@bos.polri.go.id', 'roles' => [5],  'password' => '82010689' ],
[  'nrp' =>'86110027', 'email' => '86110027@bos.polri.go.id', 'roles' => [5],  'password' => '86110027' ],
[  'nrp' =>'86121020', 'email' => '86121020@bos.polri.go.id', 'roles' => [5],  'password' => '86121020' ],
[  'nrp' =>'87091307', 'email' => '87091307@bos.polri.go.id', 'roles' => [5],  'password' => '87091307' ],
[  'nrp' =>'89040212', 'email' => '89040212@bos.polri.go.id', 'roles' => [5],  'password' => '89040212' ],
[  'nrp' =>'80060698', 'email' => '80060698@bos.polri.go.id', 'roles' => [5],  'password' => '80060698' ],
[  'nrp' =>'83100835', 'email' => '83100835@bos.polri.go.id', 'roles' => [5],  'password' => '83100835' ],
[  'nrp' =>'87020326', 'email' => '87020326@bos.polri.go.id', 'roles' => [5],  'password' => '87020326' ],
[  'nrp' =>'85051212', 'email' => '85051212@bos.polri.go.id', 'roles' => [5],  'password' => '85051212' ],
[  'nrp' =>'80060993', 'email' => '80060993@bos.polri.go.id', 'roles' => [5],  'password' => '80060993' ],
[  'nrp' =>'89030498', 'email' => '89030498@bos.polri.go.id', 'roles' => [5],  'password' => '89030498' ],
[  'nrp' =>'85070850', 'email' => '85070850@bos.polri.go.id', 'roles' => [5],  'password' => '85070850' ],
[  'nrp' =>'82080367', 'email' => '82080367@bos.polri.go.id', 'roles' => [5],  'password' => '82080367' ],
[  'nrp' =>'8606843', 'email' => '8606843@bos.polri.go.id', 'roles' => [5],  'password' => '8606843' ],
[  'nrp' =>'76060096', 'email' => '76060096@bos.polri.go.id', 'roles' => [5],  'password' => '76060096' ],
[  'nrp' =>'88110193', 'email' => '88110193@bos.polri.go.id', 'roles' => [5],  'password' => '88110193' ],
[  'nrp' =>'85041565', 'email' => '85041565@bos.polri.go.id', 'roles' => [5],  'password' => '85041565' ],
[  'nrp' =>'87051372', 'email' => '87051372@bos.polri.go.id', 'roles' => [5],  'password' => '87051372' ],
[  'nrp' =>'91110513', 'email' => '91110513@bos.polri.go.id', 'roles' => [5],  'password' => '91110513' ],
[  'nrp' =>'91100098', 'email' => '91100098@bos.polri.go.id', 'roles' => [5],  'password' => '91100098' ],
[  'nrp' =>'87120853', 'email' => '87120853@bos.polri.go.id', 'roles' => [5],  'password' => '87120853' ],
[  'nrp' =>'80040724', 'email' => '80040724@bos.polri.go.id', 'roles' => [5],  'password' => '80040724' ],
[  'nrp' =>'84090638', 'email' => '84090638@bos.polri.go.id', 'roles' => [5],  'password' => '84090638' ],
[  'nrp' =>'84100195', 'email' => '84100195@bos.polri.go.id', 'roles' => [5],  'password' => '84100195' ],

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
