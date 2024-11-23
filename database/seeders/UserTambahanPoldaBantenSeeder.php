<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaBantenSeeder extends Seeder
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
            [  'nrp' =>'87050203', 'email' => '87050203@bos.polri.go.id', 'roles' => [5],  'password' => '87050203' ],
            [  'nrp' =>'88081094', 'email' => '88081094@bos.polri.go.id', 'roles' => [5],  'password' => '88081094' ],
            [  'nrp' =>'89020554', 'email' => '89020554@bos.polri.go.id', 'roles' => [5],  'password' => '89020554' ],
[  'nrp' =>'86061723', 'email' => '86061723@bos.polri.go.id', 'roles' => [5],  'password' => '86061723' ],
[  'nrp' =>'89050624', 'email' => '89050624@bos.polri.go.id', 'roles' => [5],  'password' => '89050624' ],
[  'nrp' =>'89090411', 'email' => '89090411@bos.polri.go.id', 'roles' => [5],  'password' => '89090411' ],
[  'nrp' =>'89060520', 'email' => '89060520@bos.polri.go.id', 'roles' => [5],  'password' => '89060520' ],
[  'nrp' =>'90050266', 'email' => '90050266@bos.polri.go.id', 'roles' => [5],  'password' => '90050266' ],
[  'nrp' =>'87010725', 'email' => '87010725@bos.polri.go.id', 'roles' => [5],  'password' => '87010725' ],
[  'nrp' =>'86050434', 'email' => '86050434@bos.polri.go.id', 'roles' => [5],  'password' => '86050434' ],
[  'nrp' =>'86042086', 'email' => '86042086@bos.polri.go.id', 'roles' => [5],  'password' => '86042086' ],
[  'nrp' =>'82060760', 'email' => '82060760@bos.polri.go.id', 'roles' => [5],  'password' => '82060760' ],
[  'nrp' =>'74050355', 'email' => '74050355@bos.polri.go.id', 'roles' => [5],  'password' => '74050355' ],
[  'nrp' =>'72110027', 'email' => '72110027@bos.polri.go.id', 'roles' => [5],  'password' => '72110027' ],
[  'nrp' =>'65100005', 'email' => '65100005@bos.polri.go.id', 'roles' => [5],  'password' => '65100005' ],
[  'nrp' =>'67020525', 'email' => '67020525@bos.polri.go.id', 'roles' => [5],  'password' => '67020525' ],
[  'nrp' =>'63120556', 'email' => '63120556@bos.polri.go.id', 'roles' => [5],  'password' => '63120556' ],
[  'nrp' =>'86120791', 'email' => '86120791@bos.polri.go.id', 'roles' => [5],  'password' => '86120791' ],
[  'nrp' =>'78100811', 'email' => '78100811@bos.polri.go.id', 'roles' => [5],  'password' => '78100811' ],
[  'nrp' =>'86042085', 'email' => '86042085@bos.polri.go.id', 'roles' => [5],  'password' => '86042085' ],
[  'nrp' =>'84010526', 'email' => '84010526@bos.polri.go.id', 'roles' => [5],  'password' => '84010526' ],
[  'nrp' =>'84010526', 'email' => '84010526@bos.polri.go.id', 'roles' => [5],  'password' => '84010526' ],
[  'nrp' =>'87041320', 'email' => '87041320@bos.polri.go.id', 'roles' => [5],  'password' => '87041320' ],
[  'nrp' =>'94010359', 'email' => '94010359@bos.polri.go.id', 'roles' => [5],  'password' => '94010359' ],
[  'nrp' =>'84080678', 'email' => '84080678@bos.polri.go.id', 'roles' => [5],  'password' => '84080678' ],
[  'nrp' =>'84120739', 'email' => '84120739@bos.polri.go.id', 'roles' => [5],  'password' => '84120739' ],
[  'nrp' =>'93060565', 'email' => '93060565@bos.polri.go.id', 'roles' => [5],  'password' => '93060565' ],
[  'nrp' =>'86020800', 'email' => '86020800@bos.polri.go.id', 'roles' => [5],  'password' => '86020800' ],
[  'nrp' =>'85091899', 'email' => '85091899@bos.polri.go.id', 'roles' => [5],  'password' => '85091899' ],
[  'nrp' =>'84111598', 'email' => '84111598@bos.polri.go.id', 'roles' => [5],  'password' => '84111598' ],
[  'nrp' =>'78050394', 'email' => '78050394@bos.polri.go.id', 'roles' => [5],  'password' => '78050394' ],
[  'nrp' =>'88100954', 'email' => '88100954@bos.polri.go.id', 'roles' => [5],  'password' => '88100954' ],
[  'nrp' =>'96010137', 'email' => '96010137@bos.polri.go.id', 'roles' => [5],  'password' => '96010137' ],
[  'nrp' =>'77100642', 'email' => '77100642@bos.polri.go.id', 'roles' => [5],  'password' => '77100642' ],
[  'nrp' =>'87031522', 'email' => '87031522@bos.polri.go.id', 'roles' => [5],  'password' => '87031522' ],
[  'nrp' =>'90040169', 'email' => '90040169@bos.polri.go.id', 'roles' => [5],  'password' => '90040169' ],
[  'nrp' =>'86061717', 'email' => '86061717@bos.polri.go.id', 'roles' => [5],  'password' => '86061717' ],
[  'nrp' =>'85111457', 'email' => '85111457@bos.polri.go.id', 'roles' => [5],  'password' => '85111457' ],
[  'nrp' =>'86101676', 'email' => '86101676@bos.polri.go.id', 'roles' => [5],  'password' => '86101676' ],
[  'nrp' =>'77090626', 'email' => '77090626@bos.polri.go.id', 'roles' => [5],  'password' => '77090626' ],
[  'nrp' =>'90030024', 'email' => '90030024@bos.polri.go.id', 'roles' => [5],  'password' => '90030024' ],
[  'nrp' =>'88090423', 'email' => '88090423@bos.polri.go.id', 'roles' => [5],  'password' => '88090423' ],
[  'nrp' =>'94030619', 'email' => '94030619@bos.polri.go.id', 'roles' => [5],  'password' => '94030619' ],
[  'nrp' =>'96030082', 'email' => '96030082@bos.polri.go.id', 'roles' => [5],  'password' => '96030082' ],
[  'nrp' =>'89110109', 'email' => '89110109@bos.polri.go.id', 'roles' => [5],  'password' => '89110109' ],
[  'nrp' =>'89060624', 'email' => '89060624@bos.polri.go.id', 'roles' => [5],  'password' => '89060624' ],
[  'nrp' =>'84121778', 'email' => '84121778@bos.polri.go.id', 'roles' => [5],  'password' => '84121778' ],
[  'nrp' =>'84091308', 'email' => '84091308@bos.polri.go.id', 'roles' => [5],  'password' => '84091308' ],
[  'nrp' =>'89090613', 'email' => '89090613@bos.polri.go.id', 'roles' => [5],  'password' => '89090613' ],
[  'nrp' =>'97100648', 'email' => '97100648@bos.polri.go.id', 'roles' => [5],  'password' => '97100648' ],
[  'nrp' =>'89070619', 'email' => '89070619@bos.polri.go.id', 'roles' => [5],  'password' => '89070619' ],
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
