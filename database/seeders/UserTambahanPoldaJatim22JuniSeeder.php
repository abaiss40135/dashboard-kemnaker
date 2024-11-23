<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaJatim22JuniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [  'nrp' =>'63020095', 'email' => '63020095@bos.polri.go.id', 'roles' => [5],  'password' => '63020095' ],
            [  'nrp' =>'63040708', 'email' => '63040708@bos.polri.go.id', 'roles' => [5],  'password' => '63040708' ],
            [  'nrp' =>'75110716', 'email' => '75110716@bos.polri.go.id', 'roles' => [5],  'password' => '75110716' ],
            [  'nrp' =>'66010275', 'email' => '66010275@bos.polri.go.id', 'roles' => [5],  'password' => '66010275' ],
            [  'nrp' =>'77040486', 'email' => '77040486@bos.polri.go.id', 'roles' => [5],  'password' => '77040486' ],
            [  'nrp' =>'75100129', 'email' => '75100129@bos.polri.go.id', 'roles' => [5],  'password' => '75100129' ],
            [  'nrp' =>'77120270', 'email' => '77120270@bos.polri.go.id', 'roles' => [5],  'password' => '77120270' ],
            [  'nrp' =>'75030456', 'email' => '75030456@bos.polri.go.id', 'roles' => [5],  'password' => '75030456' ],
            [  'nrp' =>'76050475', 'email' => '76050475@bos.polri.go.id', 'roles' => [5],  'password' => '76050475' ],
            [  'nrp' =>'86060534', 'email' => '86060534@bos.polri.go.id', 'roles' => [5],  'password' => '86060534' ],
            [  'nrp' =>'74050510', 'email' => '74050510@bos.polri.go.id', 'roles' => [5],  'password' => '74050510' ],
            [  'nrp' =>'64100613', 'email' => '64100613@bos.polri.go.id', 'roles' => [5],  'password' => '64100613' ],
            [  'nrp' =>'68090443', 'email' => '68090443@bos.polri.go.id', 'roles' => [5],  'password' => '68090443' ],
            [  'nrp' =>'79100809', 'email' => '79100809@bos.polri.go.id', 'roles' => [5],  'password' => '79100809' ],
            [  'nrp' =>'78010994', 'email' => '78010994@bos.polri.go.id', 'roles' => [5],  'password' => '78010994' ],
            [  'nrp' =>'70060130', 'email' => '70060130@bos.polri.go.id', 'roles' => [5],  'password' => '70060130' ]
        ];

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
