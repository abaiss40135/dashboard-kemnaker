<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaSultengSeeder extends Seeder
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
            [  'nrp' =>'72050513', 'email' => '72050513@bos.polri.go.id', 'roles' => [5],  'password' => '72050513' ],
            [  'nrp' =>'83041180', 'email' => '83041180@bos.polri.go.id', 'roles' => [5],  'password' => '83041180' ],
[  'nrp' =>'84021379', 'email' => '84021379@bos.polri.go.id', 'roles' => [5],  'password' => '84021379' ],
[  'nrp' =>'79021055', 'email' => '79021055@bos.polri.go.id', 'roles' => [5],  'password' => '79021055' ],
[  'nrp' =>'89060650', 'email' => '89060650@bos.polri.go.id', 'roles' => [5],  'password' => '89060650' ],
[  'nrp' =>'86110831', 'email' => '86110831@bos.polri.go.id', 'roles' => [5],  'password' => '86110831' ],
[  'nrp' =>'91080447', 'email' => '91080447@bos.polri.go.id', 'roles' => [5],  'password' => '91080447' ],
[  'nrp' =>'87020037', 'email' => '87020037@bos.polri.go.id', 'roles' => [5],  'password' => '87020037' ],
[  'nrp' =>'83091152', 'email' => '83091152@bos.polri.go.id', 'roles' => [5],  'password' => '83091152' ],
[  'nrp' =>'82111111', 'email' => '82111111@bos.polri.go.id', 'roles' => [5],  'password' => '82111111' ],
[  'nrp' =>'94051031', 'email' => '94051031@bos.polri.go.id', 'roles' => [5],  'password' => '94051031' ],
[  'nrp' =>'84101402', 'email' => '84101402@bos.polri.go.id', 'roles' => [5],  'password' => '84101402' ],
[  'nrp' =>'80050263', 'email' => '80050263@bos.polri.go.id', 'roles' => [5],  'password' => '80050263' ],
[  'nrp' =>'91050157', 'email' => '91050157@bos.polri.go.id', 'roles' => [5],  'password' => '91050157' ],
[  'nrp' =>'94041004', 'email' => '94041004@bos.polri.go.id', 'roles' => [5],  'password' => '94041004' ],
[  'nrp' =>'85041929', 'email' => '85041929@bos.polri.go.id', 'roles' => [5],  'password' => '85041929' ],
[  'nrp' =>'88031081', 'email' => '88031081@bos.polri.go.id', 'roles' => [5],  'password' => '88031081' ],
[  'nrp' =>'80120420', 'email' => '80120420@bos.polri.go.id', 'roles' => [5],  'password' => '80120420' ],
[  'nrp' =>'93020187', 'email' => '93020187@bos.polri.go.id', 'roles' => [5],  'password' => '93020187' ],
[  'nrp' =>'95080435', 'email' => '95080435@bos.polri.go.id', 'roles' => [5],  'password' => '95080435' ],
[  'nrp' =>'96110884', 'email' => '96110884@bos.polri.go.id', 'roles' => [5],  'password' => '96110884' ],
[  'nrp' =>'88090054', 'email' => '88090054@bos.polri.go.id', 'roles' => [5],  'password' => '88090054' ],
[  'nrp' =>'87120083', 'email' => '87120083@bos.polri.go.id', 'roles' => [5],  'password' => '87120083' ],
[  'nrp' =>'93070768', 'email' => '93070768@bos.polri.go.id', 'roles' => [5],  'password' => '93070768' ],
[  'nrp' =>'88050658', 'email' => '88050658@bos.polri.go.id', 'roles' => [5],  'password' => '88050658' ],
[  'nrp' =>'79070572', 'email' => '79070572@bos.polri.go.id', 'roles' => [5],  'password' => '79070572' ],
[  'nrp' =>'82090488', 'email' => '82090488@bos.polri.go.id', 'roles' => [5],  'password' => '82090488' ],
[  'nrp' =>'850991195', 'email' => '850991195@bos.polri.go.id', 'roles' => [5],  'password' => '850991195' ],
[  'nrp' =>'79120465', 'email' => '79120465@bos.polri.go.id', 'roles' => [5],  'password' => '79120465' ],
[  'nrp' =>'87120690', 'email' => '87120690@bos.polri.go.id', 'roles' => [5],  'password' => '87120690' ],
[  'nrp' =>'81020828', 'email' => '81020828@bos.polri.go.id', 'roles' => [5],  'password' => '81020828' ],
[  'nrp' =>'94030748', 'email' => '94030748@bos.polri.go.id', 'roles' => [5],  'password' => '94030748' ],
[  'nrp' =>'82010060', 'email' => '82010060@bos.polri.go.id', 'roles' => [5],  'password' => '82010060' ],
[  'nrp' =>'83070726', 'email' => '83070726@bos.polri.go.id', 'roles' => [5],  'password' => '83070726' ],
           


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
