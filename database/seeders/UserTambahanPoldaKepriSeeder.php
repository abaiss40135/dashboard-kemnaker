<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaKepriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['nrp' => '82030295', 'email' => '82030295@bos.polri.go.id', 'roles' => [5], 'password' => '82030295'],
            ['nrp' => '85041578', 'email' => '85041578@bos.polri.go.id', 'roles' => [5], 'password' => '85041578'],
            ['nrp' => '84050942', 'email' => '84050942@bos.polri.go.id', 'roles' => [5], 'password' => '84050942'],
            ['nrp' => '96080335', 'email' => '96080335@bos.polri.go.id', 'roles' => [5], 'password' => '96080335'],
            ['nrp' => '88100991', 'email' => '88100991@bos.polri.go.id', 'roles' => [5], 'password' => '88100991'],
            ['nrp' => '84121654', 'email' => '84121654@bos.polri.go.id', 'roles' => [5], 'password' => '84121654'],
            ['nrp' => '82081142', 'email' => '82081142@bos.polri.go.id', 'roles' => [5], 'password' => '82081142'],
            ['nrp' => '86010355', 'email' => '86010355@bos.polri.go.id', 'roles' => [5], 'password' => '86010355'],
            ['nrp' => '86101378', 'email' => '86101378@bos.polri.go.id', 'roles' => [5], 'password' => '86101378'],
            ['nrp' => '95070560', 'email' => '95070560@bos.polri.go.id', 'roles' => [5], 'password' => '95070560'],
            ['nrp' => '93030018', 'email' => '93030018@bos.polri.go.id', 'roles' => [5], 'password' => '93030018'],
            ['nrp' => '95010226', 'email' => '95010226@bos.polri.go.id', 'roles' => [5], 'password' => '95010226'],
            ['nrp' => '93070976', 'email' => '93070976@bos.polri.go.id', 'roles' => [5], 'password' => '93070976'],
            ['nrp' => '97010181', 'email' => '97010181@bos.polri.go.id', 'roles' => [5], 'password' => '97010181'],
            ['nrp' => '96080295', 'email' => '96080295@bos.polri.go.id', 'roles' => [5], 'password' => '96080295'],
            ['nrp' => '95110307', 'email' => '95110307@bos.polri.go.id', 'roles' => [5], 'password' => '95110307'],
            ['nrp' => '92120894', 'email' => '92120894@bos.polri.go.id', 'roles' => [5], 'password' => '92120894'],
            ['nrp' => '92080107', 'email' => '92080107@bos.polri.go.id', 'roles' => [5], 'password' => '92080107'],
            ['nrp' => '96110241', 'email' => '96110241@bos.polri.go.id', 'roles' => [5], 'password' => '96110241'],
            ['nrp' => '79040505', 'email' => '79040505@bos.polri.go.id', 'roles' => [5], 'password' => '79040505'],
            ['nrp' => '93110830', 'email' => '93110830@bos.polri.go.id', 'roles' => [5], 'password' => '93110830'],
            ['nrp' => '96040564', 'email' => '96040564@bos.polri.go.id', 'roles' => [5], 'password' => '96040564'],
            ['nrp' => '86051230', 'email' => '86051230@bos.polri.go.id', 'roles' => [5], 'password' => '86051230'],
            ['nrp' => '99040243', 'email' => '99040243@bos.polri.go.id', 'roles' => [5], 'password' => '99040243'],
            ['nrp' => '90070286', 'email' => '90070286@bos.polri.go.id', 'roles' => [5], 'password' => '90070286'],
            ['nrp' => '96040331', 'email' => '96040331@bos.polri.go.id', 'roles' => [5], 'password' => '96040331'],
            ['nrp' => '89060407', 'email' => '89060407@bos.polri.go.id', 'roles' => [5], 'password' => '89060407'],
            ['nrp' => '93061013', 'email' => '93061013@bos.polri.go.id', 'roles' => [5], 'password' => '93061013'],
            ['nrp' => '95040496', 'email' => '95040496@bos.polri.go.id', 'roles' => [5], 'password' => '95040496'],
            ['nrp' => '95120220', 'email' => '95120220@bos.polri.go.id', 'roles' => [5], 'password' => '95120220'],
            ['nrp' => '94100930', 'email' => '94100930@bos.polri.go.id', 'roles' => [5], 'password' => '94100930'],
            ['nrp' => '93040940', 'email' => '93040940@bos.polri.go.id', 'roles' => [5], 'password' => '93040940'],
            ['nrp' => '94101189', 'email' => '94101189@bos.polri.go.id', 'roles' => [5], 'password' => '94101189'],
            ['nrp' => '93051026', 'email' => '93051026@bos.polri.go.id', 'roles' => [5], 'password' => '93051026'],
            ['nrp' => '94061034', 'email' => '94061034@bos.polri.go.id', 'roles' => [5], 'password' => '94061034'],
            ['nrp' => '95020480', 'email' => '95020480@bos.polri.go.id', 'roles' => [5], 'password' => '95020480'],
            ['nrp' => '94110829', 'email' => '94110829@bos.polri.go.id', 'roles' => [5], 'password' => '94110829'],
            ['nrp' => '96030138', 'email' => '96030138@bos.polri.go.id', 'roles' => [5], 'password' => '96030138'],
            ['nrp' => '95050775', 'email' => '95050775@bos.polri.go.id', 'roles' => [5], 'password' => '95050775'],
            ['nrp' => '88100991', 'email' => '88100991@bos.polri.go.id', 'roles' => [5], 'password' => '88100991'],
            ['nrp' => '86011352', 'email' => '86011352@bos.polri.go.id', 'roles' => [5], 'password' => '86011352'],
            ['nrp' => '85041754', 'email' => '85041754@bos.polri.go.id', 'roles' => [5], 'password' => '85041754'],
            ['nrp' => '95120764', 'email' => '95120764@bos.polri.go.id', 'roles' => [5], 'password' => '95120764'],
            ['nrp' => '85040555', 'email' => '85040555@bos.polri.go.id', 'roles' => [5], 'password' => '85040555'],
            ['nrp' => '82110917', 'email' => '82110917@bos.polri.go.id', 'roles' => [5], 'password' => '82110917'],
            ['nrp' => '95090356', 'email' => '95090356@bos.polri.go.id', 'roles' => [5], 'password' => '95090356'],
            ['nrp' => '97040094', 'email' => '97040094@bos.polri.go.id', 'roles' => [5], 'password' => '97040094'],
            ['nrp' => '82100928', 'email' => '82100928@bos.polri.go.id', 'roles' => [5], 'password' => '82100928'],
            // 28 Juni 2021
            ['nrp' => '77120331', 'email' => '77120331@bos.polri.go.id', 'roles' => [5], 'password' => '77120331'],

        ];

        foreach ($datas as $key => $data) {
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
