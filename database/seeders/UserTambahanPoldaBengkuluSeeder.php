<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaBengkuluSeeder extends Seeder
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
            [  'nrp' =>'74110400', 'email' => '74110400@bos.polri.go.id', 'roles' => [5],  'password' => '74110400' ],
            [  'nrp' =>'85120998', 'email' => '85120998@bos.polri.go.id', 'roles' => [5],  'password' => '85120998' ],
            [  'nrp' =>'89030102', 'email' => '89030102@bos.polri.go.id', 'roles' => [5],  'password' => '89030102' ],
[  'nrp' =>'89050401', 'email' => '89050401@bos.polri.go.id', 'roles' => [5],  'password' => '89050401' ],
[  'nrp' =>'88110064', 'email' => '88110064@bos.polri.go.id', 'roles' => [5],  'password' => '88110064' ],
[  'nrp' =>'85071136', 'email' => '85071136@bos.polri.go.id', 'roles' => [5],  'password' => '85071136' ],
[  'nrp' =>'74110400', 'email' => '74110400@bos.polri.go.id', 'roles' => [5],  'password' => '74110400' ],
[  'nrp' =>'85071642', 'email' => '85071642@bos.polri.go.id', 'roles' => [5],  'password' => '85071642' ],
[  'nrp' =>'87040401', 'email' => '87040401@bos.polri.go.id', 'roles' => [5],  'password' => '87040401' ],
[  'nrp' =>'85120998', 'email' => '85120998@bos.polri.go.id', 'roles' => [5],  'password' => '85120998' ],
[  'nrp' =>'79100995', 'email' => '79100995@bos.polri.go.id', 'roles' => [5],  'password' => '79100995' ],
[  'nrp' =>'83090227', 'email' => '83090227@bos.polri.go.id', 'roles' => [5],  'password' => '83090227' ],
[  'nrp' =>'84051561', 'email' => '84051561@bos.polri.go.id', 'roles' => [5],  'password' => '84051561' ],
[  'nrp' =>'86110532', 'email' => '86110532@bos.polri.go.id', 'roles' => [5],  'password' => '86110532' ],
[  'nrp' =>'82070736', 'email' => '82070736@bos.polri.go.id', 'roles' => [5],  'password' => '82070736' ],
[  'nrp' =>'87030725', 'email' => '87030725@bos.polri.go.id', 'roles' => [5],  'password' => '87030725' ],
[  'nrp' =>'78110868', 'email' => '78110868@bos.polri.go.id', 'roles' => [5],  'password' => '78110868' ],
[  'nrp' =>'78120634', 'email' => '78120634@bos.polri.go.id', 'roles' => [5],  'password' => '78120634' ],
[  'nrp' =>'80060289', 'email' => '80060289@bos.polri.go.id', 'roles' => [5],  'password' => '80060289' ],
[  'nrp' =>'81020403', 'email' => '81020403@bos.polri.go.id', 'roles' => [5],  'password' => '81020403' ],
[  'nrp' =>'80010122', 'email' => '80010122@bos.polri.go.id', 'roles' => [5],  'password' => '80010122' ],
[  'nrp' =>'78080212', 'email' => '78080212@bos.polri.go.id', 'roles' => [5],  'password' => '78080212' ],
[  'nrp' =>'77020671', 'email' => '77020671@bos.polri.go.id', 'roles' => [5],  'password' => '77020671' ],
[  'nrp' =>'79090831', 'email' => '79090831@bos.polri.go.id', 'roles' => [5],  'password' => '79090831' ],
[  'nrp' =>'86030758', 'email' => '86030758@bos.polri.go.id', 'roles' => [5],  'password' => '86030758' ],
[  'nrp' =>'88060961', 'email' => '88060961@bos.polri.go.id', 'roles' => [5],  'password' => '88060961' ],
[  'nrp' =>'88040490', 'email' => '88040490@bos.polri.go.id', 'roles' => [5],  'password' => '88040490' ],
[  'nrp' =>'84081342', 'email' => '84081342@bos.polri.go.id', 'roles' => [5],  'password' => '84081342' ],
[  'nrp' =>'87070363', 'email' => '87070363@bos.polri.go.id', 'roles' => [5],  'password' => '87070363' ],
[  'nrp' =>'81100743', 'email' => '81100743@bos.polri.go.id', 'roles' => [5],  'password' => '81100743' ],
[  'nrp' =>'76080999', 'email' => '76080999@bos.polri.go.id', 'roles' => [5],  'password' => '76080999' ],
[  'nrp' =>'83030034', 'email' => '83030034@bos.polri.go.id', 'roles' => [5],  'password' => '83030034' ],
[  'nrp' =>'84050621', 'email' => '84050621@bos.polri.go.id', 'roles' => [5],  'password' => '84050621' ],
[  'nrp' =>'76090906', 'email' => '76090906@bos.polri.go.id', 'roles' => [5],  'password' => '76090906' ],
[  'nrp' =>'78060619', 'email' => '78060619@bos.polri.go.id', 'roles' => [5],  'password' => '78060619' ],
[  'nrp' =>'89050401', 'email' => '89050401@bos.polri.go.id', 'roles' => [5],  'password' => '89050401' ],
[  'nrp' =>'92070677', 'email' => '92070677@bos.polri.go.id', 'roles' => [5],  'password' => '92070677' ],
[  'nrp' =>'80011012', 'email' => '80011012@bos.polri.go.id', 'roles' => [5],  'password' => '80011012' ],
[  'nrp' =>'78081599', 'email' => '78081599@bos.polri.go.id', 'roles' => [5],  'password' => '78081599' ],
[  'nrp' =>'79091146', 'email' => '79091146@bos.polri.go.id', 'roles' => [5],  'password' => '79091146' ],
[  'nrp' =>'86050828', 'email' => '86050828@bos.polri.go.id', 'roles' => [5],  'password' => '86050828' ],
[  'nrp' =>'80020668', 'email' => '80020668@bos.polri.go.id', 'roles' => [5],  'password' => '80020668' ],
[  'nrp' =>'81020651', 'email' => '81020651@bos.polri.go.id', 'roles' => [5],  'password' => '81020651' ],
[  'nrp' =>'81070318', 'email' => '81070318@bos.polri.go.id', 'roles' => [5],  'password' => '81070318' ],


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
