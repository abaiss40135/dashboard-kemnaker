<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class UserPoldaBaliSeeder extends Seeder
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
            [  'nrp' =>'65030090', 'email' => '65030090@bos.polri.go.id', 'roles' => [5],  'password' => '65030090' ],
            [  'nrp' =>'79090464', 'email' => '79090464@bos.polri.go.id', 'roles' => [5],  'password' => '79090464' ],
            [  'nrp' =>'64010298', 'email' => '64010298@bos.polri.go.id', 'roles' => [5],  'password' => '64010298' ],
            [  'nrp' =>'65030087', 'email' => '65030087@bos.polri.go.id', 'roles' => [5],  'password' => '65030087' ],
            [  'nrp' =>'67040344', 'email' => '67040344@bos.polri.go.id', 'roles' => [5],  'password' => '67040344' ],
            [  'nrp' =>'79071248', 'email' => '79071248@bos.polri.go.id', 'roles' => [5],  'password' => '79071248' ],
            [  'nrp' =>'78020736', 'email' => '78020736@bos.polri.go.id', 'roles' => [5],  'password' => '78020736' ],
            [  'nrp' =>'69110019', 'email' => '69110019@bos.polri.go.id', 'roles' => [5],  'password' => '69110019' ],
            [  'nrp' =>'78080392', 'email' => '78080392@bos.polri.go.id', 'roles' => [5],  'password' => '78080392' ],
            [  'nrp' =>'64060318', 'email' => '64060318@bos.polri.go.id', 'roles' => [5],  'password' => '64060318' ],
            [  'nrp' =>'75100768', 'email' => '75100768@bos.polri.go.id', 'roles' => [5],  'password' => '75100768' ],
            [  'nrp' =>'64010100', 'email' => '64010100@bos.polri.go.id', 'roles' => [5],  'password' => '64010100' ],
            [  'nrp' =>'69100150', 'email' => '69100150@bos.polri.go.id', 'roles' => [5],  'password' => '69100150' ],
            [  'nrp' =>'64040363', 'email' => '64040363@bos.polri.go.id', 'roles' => [5],  'password' => '64040363' ],
            [  'nrp' =>'64120209', 'email' => '64120209@bos.polri.go.id', 'roles' => [5],  'password' => '64120209' ],
            [  'nrp' =>'69030326', 'email' => '69030326@bos.polri.go.id', 'roles' => [5],  'password' => '69030326' ],
            [  'nrp' =>'76030168', 'email' => '76030168@bos.polri.go.id', 'roles' => [5],  'password' => '76030168' ],
            [  'nrp' =>'70110112', 'email' => '70110112@bos.polri.go.id', 'roles' => [5],  'password' => '70110112' ],
            [  'nrp' =>'65120837', 'email' => '65120837@bos.polri.go.id', 'roles' => [5],  'password' => '65120837' ],
            [  'nrp' =>'66030208', 'email' => '66030208@bos.polri.go.id', 'roles' => [5],  'password' => '66030208' ],
            [  'nrp' =>'68050249', 'email' => '68050249@bos.polri.go.id', 'roles' => [5],  'password' => '68050249' ],
            [  'nrp' =>'76030136', 'email' => '76030136@bos.polri.go.id', 'roles' => [5],  'password' => '76030136' ],
            [  'nrp' =>'88120791', 'email' => '88120791@bos.polri.go.id', 'roles' => [5],  'password' => '88120791' ],
            [  'nrp' =>'79051631', 'email' => '79051631@bos.polri.go.id', 'roles' => [5],  'password' => '79051631' ],
            [  'nrp' =>'71060296', 'email' => '71060296@bos.polri.go.id', 'roles' => [5],  'password' => '71060296' ],
            [  'nrp' =>'78120092', 'email' => '78120092@bos.polri.go.id', 'roles' => [5],  'password' => '78120092' ],
            [  'nrp' =>'82050796', 'email' => '82050796@bos.polri.go.id', 'roles' => [5],  'password' => '82050796' ],
            [  'nrp' =>'64040015', 'email' => '64040015@bos.polri.go.id', 'roles' => [5],  'password' => '64040015' ],
            [  'nrp' =>'79051191', 'email' => '79051191@bos.polri.go.id', 'roles' => [5],  'password' => '79051191' ],
            [  'nrp' =>'72040355', 'email' => '72040355@bos.polri.go.id', 'roles' => [5],  'password' => '72040355' ],
            [  'nrp' =>'88120676', 'email' => '88120676@bos.polri.go.id', 'roles' => [5],  'password' => '88120676' ],
            [  'nrp' =>'76120559', 'email' => '76120559@bos.polri.go.id', 'roles' => [5],  'password' => '76120559' ],
            [  'nrp' =>'68080516', 'email' => '68080516@bos.polri.go.id', 'roles' => [5],  'password' => '68080516' ],
            [  'nrp' =>'63100515', 'email' => '63100515@bos.polri.go.id', 'roles' => [5],  'password' => '63100515' ],
            [  'nrp' =>'65100692', 'email' => '65100692@bos.polri.go.id', 'roles' => [5],  'password' => '65100692' ],
            [  'nrp' =>'77070279', 'email' => '77070279@bos.polri.go.id', 'roles' => [5],  'password' => '77070279' ],
            [  'nrp' =>'76060581', 'email' => '76060581@bos.polri.go.id', 'roles' => [5],  'password' => '76060581' ],
            [  'nrp' =>'72100147', 'email' => '72100147@bos.polri.go.id', 'roles' => [5],  'password' => '72100147' ],
            [  'nrp' =>'64050310', 'email' => '64050310@bos.polri.go.id', 'roles' => [5],  'password' => '64050310' ],
            [  'nrp' =>'67010062', 'email' => '67010062@bos.polri.go.id', 'roles' => [5],  'password' => '67010062' ],
            [  'nrp' =>'78100097', 'email' => '78100097@bos.polri.go.id', 'roles' => [5],  'password' => '78100097' ],
            [  'nrp' =>'84020669', 'email' => '84020669@bos.polri.go.id', 'roles' => [5],  'password' => '84020669' ],
            [  'nrp' =>'77090038', 'email' => '77090038@bos.polri.go.id', 'roles' => [5],  'password' => '77090038' ],
            [  'nrp' =>'64110292', 'email' => '64110292@bos.polri.go.id', 'roles' => [5],  'password' => '64110292' ],
            [  'nrp' =>'70010300', 'email' => '70010300@bos.polri.go.id', 'roles' => [5],  'password' => '70010300' ],
            [  'nrp' =>'69040190', 'email' => '69040190@bos.polri.go.id', 'roles' => [5],  'password' => '69040190' ],
            [  'nrp' =>'75050159', 'email' => '75050159@bos.polri.go.id', 'roles' => [5],  'password' => '75050159' ],
            [  'nrp' =>'67120411', 'email' => '67120411@bos.polri.go.id', 'roles' => [5],  'password' => '67120411' ],
            [  'nrp' =>'78060880', 'email' => '78060880@bos.polri.go.id', 'roles' => [5],  'password' => '78060880' ],
            [  'nrp' =>'66100374', 'email' => '66100374@bos.polri.go.id', 'roles' => [5],  'password' => '66100374' ],
            [  'nrp' =>'64040706', 'email' => '64040706@bos.polri.go.id', 'roles' => [5],  'password' => '64040706' ],
            [  'nrp' =>'63040624', 'email' => '63040624@bos.polri.go.id', 'roles' => [5],  'password' => '63040624' ],
            [  'nrp' =>'74110211', 'email' => '74110211@bos.polri.go.id', 'roles' => [5],  'password' => '74110211' ],
            [  'nrp' =>'75010705', 'email' => '75010705@bos.polri.go.id', 'roles' => [5],  'password' => '75010705' ],
            [  'nrp' =>'72090119', 'email' => '72090119@bos.polri.go.id', 'roles' => [5],  'password' => '72090119' ],
            [  'nrp' =>'64070370', 'email' => '64070370@bos.polri.go.id', 'roles' => [5],  'password' => '64070370' ],
            [  'nrp' =>'64040583', 'email' => '64040583@bos.polri.go.id', 'roles' => [5],  'password' => '64040583' ],
            [  'nrp' =>'66030296', 'email' => '66030296@bos.polri.go.id', 'roles' => [5],  'password' => '66030296' ],
            [  'nrp' =>'69050490', 'email' => '69050490@bos.polri.go.id', 'roles' => [5],  'password' => '69050490' ],
            [  'nrp' =>'63070977', 'email' => '63070977@bos.polri.go.id', 'roles' => [5],  'password' => '63070977' ],
            [  'nrp' =>'68030180', 'email' => '68030180@bos.polri.go.id', 'roles' => [5],  'password' => '68030180' ],
            [  'nrp' =>'68010257', 'email' => '68010257@bos.polri.go.id', 'roles' => [5],  'password' => '68010257' ],
            [  'nrp' =>'65040391', 'email' => '65040391@bos.polri.go.id', 'roles' => [5],  'password' => '65040391' ],
            [  'nrp' =>'72070472', 'email' => '72070472@bos.polri.go.id', 'roles' => [5],  'password' => '72070472' ],
            [  'nrp' =>'63100409', 'email' => '63100409@bos.polri.go.id', 'roles' => [5],  'password' => '63100409' ],
            [  'nrp' =>'74080486', 'email' => '74080486@bos.polri.go.id', 'roles' => [5],  'password' => '74080486' ],
            [  'nrp' =>'70110110', 'email' => '70110110@bos.polri.go.id', 'roles' => [5],  'password' => '70110110' ],
            [  'nrp' =>'72010412', 'email' => '72010412@bos.polri.go.id', 'roles' => [5],  'password' => '72010412' ],
            [  'nrp' =>'63080768', 'email' => '63080768@bos.polri.go.id', 'roles' => [5],  'password' => '63080768' ],
            [  'nrp' =>'85071073', 'email' => '85071073@bos.polri.go.id', 'roles' => [5],  'password' => '85071073' ],
            [  'nrp' =>'63050927', 'email' => '63050927@bos.polri.go.id', 'roles' => [5],  'password' => '63050927' ],
            [  'nrp' =>'75060612', 'email' => '75060612@bos.polri.go.id', 'roles' => [5],  'password' => '75060612' ],
            [  'nrp' =>'73110366', 'email' => '73110366@bos.polri.go.id', 'roles' => [5],  'password' => '73110366' ],
            [  'nrp' =>'85121624', 'email' => '85121624@bos.polri.go.id', 'roles' => [5],  'password' => '85121624' ],
            [  'nrp' =>'72090208', 'email' => '72090208@bos.polri.go.id', 'roles' => [5],  'password' => '72090208' ],
            [  'nrp' =>'66120487', 'email' => '66120487@bos.polri.go.id', 'roles' => [5],  'password' => '66120487' ],
            [  'nrp' =>'77030617', 'email' => '77030617@bos.polri.go.id', 'roles' => [5],  'password' => '77030617' ],
            [  'nrp' =>'74100268', 'email' => '74100268@bos.polri.go.id', 'roles' => [5],  'password' => '74100268' ],
            [  'nrp' =>'75120609', 'email' => '75120609@bos.polri.go.id', 'roles' => [5],  'password' => '75120609' ],
            [  'nrp' =>'64020078', 'email' => '64020078@bos.polri.go.id', 'roles' => [5],  'password' => '64020078' ],
            [  'nrp' =>'65020401', 'email' => '65020401@bos.polri.go.id', 'roles' => [5],  'password' => '65020401' ],
            [  'nrp' =>'77090356', 'email' => '77090356@bos.polri.go.id', 'roles' => [5],  'password' => '77090356' ],
            [  'nrp' =>'66010015', 'email' => '66010015@bos.polri.go.id', 'roles' => [5],  'password' => '66010015' ],
            [  'nrp' =>'71080413', 'email' => '71080413@bos.polri.go.id', 'roles' => [5],  'password' => '71080413' ],
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
