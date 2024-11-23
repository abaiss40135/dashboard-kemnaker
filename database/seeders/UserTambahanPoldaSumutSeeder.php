<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaSumutSeeder extends Seeder
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
            [  'nrp' =>'84041525', 'email' => '84041525@bos.polri.go.id', 'roles' => [5],  'password' => '84041525' ],
            [  'nrp' =>'82020911', 'email' => '82020911@bos.polri.go.id', 'roles' => [5],  'password' => '82020911' ],
            [  'nrp' =>'80100859', 'email' => '80100859@bos.polri.go.id', 'roles' => [5],  'password' => '80100859' ],
            [  'nrp' =>'73040389', 'email' => '73040389@bos.polri.go.id', 'roles' => [5],  'password' => '73040389' ],
[  'nrp' =>'73020642', 'email' => '73020642@bos.polri.go.id', 'roles' => [5],  'password' => '73020642' ],
[  'nrp' =>'73050434', 'email' => '73050434@bos.polri.go.id', 'roles' => [5],  'password' => '73050434' ],
[  'nrp' =>'64060210', 'email' => '64060210@bos.polri.go.id', 'roles' => [5],  'password' => '64060210' ],
[  'nrp' =>'74030094', 'email' => '74030094@bos.polri.go.id', 'roles' => [5],  'password' => '74030094' ],
[  'nrp' =>'66050543', 'email' => '66050543@bos.polri.go.id', 'roles' => [5],  'password' => '66050543' ],
[  'nrp' =>'74120166', 'email' => '74120166@bos.polri.go.id', 'roles' => [5],  'password' => '74120166' ],
[  'nrp' =>'78110964', 'email' => '78110964@bos.polri.go.id', 'roles' => [5],  'password' => '78110964' ],
[  'nrp' =>'74120166', 'email' => '74120166@bos.polri.go.id', 'roles' => [5],  'password' => '74120166' ],
[  'nrp' =>'81040193', 'email' => '81040193@bos.polri.go.id', 'roles' => [5],  'password' => '81040193' ],
[  'nrp' =>'69110021', 'email' => '69110021@bos.polri.go.id', 'roles' => [5],  'password' => '69110021' ],
[  'nrp' =>'69100313', 'email' => '69100313@bos.polri.go.id', 'roles' => [5],  'password' => '69100313' ],
[  'nrp' =>'76100480', 'email' => '76100480@bos.polri.go.id', 'roles' => [5],  'password' => '76100480' ],
[  'nrp' =>'83020464', 'email' => '83020464@bos.polri.go.id', 'roles' => [5],  'password' => '83020464' ],
[  'nrp' =>'77080561', 'email' => '77080561@bos.polri.go.id', 'roles' => [5],  'password' => '77080561' ],
[  'nrp' =>'66010158', 'email' => '66010158@bos.polri.go.id', 'roles' => [5],  'password' => '66010158' ],
[  'nrp' =>'81040267', 'email' => '81040267@bos.polri.go.id', 'roles' => [5],  'password' => '81040267' ],
[  'nrp' =>'82020692', 'email' => '82020692@bos.polri.go.id', 'roles' => [5],  'password' => '82020692' ],
[  'nrp' =>'83100321', 'email' => '83100321@bos.polri.go.id', 'roles' => [5],  'password' => '83100321' ],
[  'nrp' =>'78030409', 'email' => '78030409@bos.polri.go.id', 'roles' => [5],  'password' => '78030409' ],
[  'nrp' =>'69060434', 'email' => '69060434@bos.polri.go.id', 'roles' => [5],  'password' => '69060434' ],
[  'nrp' =>'77010441', 'email' => '77010441@bos.polri.go.id', 'roles' => [5],  'password' => '77010441' ],
[  'nrp' =>'80080455', 'email' => '80080455@bos.polri.go.id', 'roles' => [5],  'password' => '80080455' ],
[  'nrp' =>'85060623', 'email' => '85060623@bos.polri.go.id', 'roles' => [5],  'password' => '85060623' ],
[  'nrp' =>'74050734', 'email' => '74050734@bos.polri.go.id', 'roles' => [5],  'password' => '74050734' ],
[  'nrp' =>'78040400', 'email' => '78040400@bos.polri.go.id', 'roles' => [5],  'password' => '78040400' ],
[  'nrp' =>'81040088', 'email' => '81040088@bos.polri.go.id', 'roles' => [5],  'password' => '81040088' ],
[  'nrp' =>'81010506', 'email' => '81010506@bos.polri.go.id', 'roles' => [5],  'password' => '81010506' ],
[  'nrp' =>'64120936', 'email' => '64120936@bos.polri.go.id', 'roles' => [5],  'password' => '64120936' ],
[  'nrp' =>'01010112', 'email' => '01010112@bos.polri.go.id', 'roles' => [5],  'password' => '01010112' ],
[  'nrp' =>'83110460', 'email' => '83110460@bos.polri.go.id', 'roles' => [5],  'password' => '83110460' ],
[  'nrp' =>'90030125', 'email' => '90030125@bos.polri.go.id', 'roles' => [5],  'password' => '90030125' ],
[  'nrp' =>'78041025', 'email' => '78041025@bos.polri.go.id', 'roles' => [5],  'password' => '78041025' ],
[  'nrp' =>'64020066', 'email' => '64020066@bos.polri.go.id', 'roles' => [5],  'password' => '64020066' ],
[  'nrp' =>'78091163', 'email' => '78091163@bos.polri.go.id', 'roles' => [5],  'password' => '78091163' ],
[  'nrp' =>'88051037', 'email' => '88051037@bos.polri.go.id', 'roles' => [5],  'password' => '88051037' ],
[  'nrp' =>'79050693', 'email' => '79050693@bos.polri.go.id', 'roles' => [5],  'password' => '79050693' ],
[  'nrp' =>'81021073', 'email' => '81021073@bos.polri.go.id', 'roles' => [5],  'password' => '81021073' ],
[  'nrp' =>'80010827', 'email' => '80010827@bos.polri.go.id', 'roles' => [5],  'password' => '80010827' ],
[  'nrp' =>'85010863', 'email' => '85010863@bos.polri.go.id', 'roles' => [5],  'password' => '85010863' ],
[  'nrp' =>'73080200', 'email' => '73080200@bos.polri.go.id', 'roles' => [5],  'password' => '73080200' ],
[  'nrp' =>'94120537', 'email' => '94120537@bos.polri.go.id', 'roles' => [5],  'password' => '94120537' ],
[  'nrp' =>'73070191', 'email' => '73070191@bos.polri.go.id', 'roles' => [5],  'password' => '73070191' ],
[  'nrp' =>'71040099', 'email' => '71040099@bos.polri.go.id', 'roles' => [5],  'password' => '71040099' ],
[  'nrp' =>'81031098', 'email' => '81031098@bos.polri.go.id', 'roles' => [5],  'password' => '81031098' ],
[  'nrp' =>'78080985', 'email' => '78080985@bos.polri.go.id', 'roles' => [5],  'password' => '78080985' ],
[  'nrp' =>'83050072', 'email' => '83050072@bos.polri.go.id', 'roles' => [5],  'password' => '83050072' ],
[  'nrp' =>'73080678', 'email' => '73080678@bos.polri.go.id', 'roles' => [5],  'password' => '73080678' ],
[  'nrp' =>'94010452', 'email' => '94010452@bos.polri.go.id', 'roles' => [5],  'password' => '94010452' ],
[  'nrp' =>'85011166', 'email' => '85011166@bos.polri.go.id', 'roles' => [5],  'password' => '85011166' ],
[  'nrp' =>'71060194', 'email' => '71060194@bos.polri.go.id', 'roles' => [5],  'password' => '71060194' ],
[  'nrp' =>'99100129', 'email' => '99100129@bos.polri.go.id', 'roles' => [5],  'password' => '99100129' ],
[  'nrp' =>'83081460', 'email' => '83081460@bos.polri.go.id', 'roles' => [5],  'password' => '83081460' ],
[  'nrp' =>'83061123', 'email' => '83061123@bos.polri.go.id', 'roles' => [5],  'password' => '83061123' ],
[  'nrp' =>'85020569', 'email' => '85020569@bos.polri.go.id', 'roles' => [5],  'password' => '85020569' ],
[  'nrp' =>'84121138', 'email' => '84121138@bos.polri.go.id', 'roles' => [5],  'password' => '84121138' ],
[  'nrp' =>'79050700', 'email' => '79050700@bos.polri.go.id', 'roles' => [5],  'password' => '79050700' ],
[  'nrp' =>'79091066', 'email' => '79091066@bos.polri.go.id', 'roles' => [5],  'password' => '79091066' ],
[  'nrp' =>'78040081', 'email' => '78040081@bos.polri.go.id', 'roles' => [5],  'password' => '78040081' ],
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
