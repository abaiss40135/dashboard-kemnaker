<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaKalbarSeeder extends Seeder
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
            ['nrp' => '82120687', 'email' => '82120687@bos.polri.go.id', 'roles' => [5], 'password' => '82120687'],
            ['nrp' => '85101259', 'email' => '85101259@bos.polri.go.id', 'roles' => [5], 'password' => '85101259'],
            ['nrp' => '86100156', 'email' => '86100156@bos.polri.go.id', 'roles' => [5], 'password' => '86100156'],
            ['nrp' => '86090558', 'email' => '86090558@bos.polri.go.id', 'roles' => [5], 'password' => '86090558'],
            ['nrp' => '85121221', 'email' => '85121221@bos.polri.go.id', 'roles' => [5], 'password' => '85121221'],
            ['nrp' => '86020901', 'email' => '86020901@bos.polri.go.id', 'roles' => [5], 'password' => '86020901'],
            ['nrp' => '85040912', 'email' => '85040912@bos.polri.go.id', 'roles' => [5], 'password' => '85040912'],
            ['nrp' => '82110471', 'email' => '82110471@bos.polri.go.id', 'roles' => [5], 'password' => '82110471'],
            ['nrp' => '86061763', 'email' => '86061763@bos.polri.go.id', 'roles' => [5], 'password' => '86061763'],
            ['nrp' => '84061389', 'email' => '84061389@bos.polri.go.id', 'roles' => [5], 'password' => '84061389'],
            ['nrp' => '87060957', 'email' => '87060957@bos.polri.go.id', 'roles' => [5], 'password' => '87060957'],
            ['nrp' => '78110621', 'email' => '78110621@bos.polri.go.id', 'roles' => [5], 'password' => '78110621'],
            ['nrp' => '84031621', 'email' => '84031621@bos.polri.go.id', 'roles' => [5], 'password' => '84031621'],
            ['nrp' => '85110519', 'email' => '85110519@bos.polri.go.id', 'roles' => [5], 'password' => '85110519'],
            ['nrp' => '82080653', 'email' => '82080653@bos.polri.go.id', 'roles' => [5], 'password' => '82080653'],
            ['nrp' => '84010929', 'email' => '84010929@bos.polri.go.id', 'roles' => [5], 'password' => '84010929'],
            ['nrp' => '83090998', 'email' => '83090998@bos.polri.go.id', 'roles' => [5], 'password' => '83090998'],
            ['nrp' => '83091278', 'email' => '83091278@bos.polri.go.id', 'roles' => [5], 'password' => '83091278'],
            ['nrp' => '85120627', 'email' => '85120627@bos.polri.go.id', 'roles' => [5], 'password' => '85120627'],
            ['nrp' => '86120800', 'email' => '86120800@bos.polri.go.id', 'roles' => [5], 'password' => '86120800'],
            ['nrp' => '81050481', 'email' => '81050481@bos.polri.go.id', 'roles' => [5], 'password' => '81050481'],
            ['nrp' => '86071810', 'email' => '86071810@bos.polri.go.id', 'roles' => [5], 'password' => '86071810'],
            ['nrp' => '80110176', 'email' => '80110176@bos.polri.go.id', 'roles' => [5], 'password' => '80110176'],
            ['nrp' => '84030316', 'email' => '84030316@bos.polri.go.id', 'roles' => [5], 'password' => '84030316'],
            ['nrp' => '96010848', 'email' => '96010848@bos.polri.go.id', 'roles' => [5], 'password' => '96010848'],
            ['nrp' => '84110176', 'email' => '84110176@bos.polri.go.id', 'roles' => [5], 'password' => '84110176'],
            ['nrp' => '83060668', 'email' => '83060668@bos.polri.go.id', 'roles' => [5], 'password' => '83060668'],
            ['nrp' => '82120719', 'email' => '82120719@bos.polri.go.id', 'roles' => [5], 'password' => '82120719'],
            ['nrp' => '84021195', 'email' => '84021195@bos.polri.go.id', 'roles' => [5], 'password' => '84021195'],
            ['nrp' => '82051456', 'email' => '82051456@bos.polri.go.id', 'roles' => [5], 'password' => '82051456'],
            ['nrp' => '86040633', 'email' => '86040633@bos.polri.go.id', 'roles' => [5], 'password' => '86040633'],
            ['nrp' => '87070836', 'email' => '87070836@bos.polri.go.id', 'roles' => [5], 'password' => '87070836'],
            ['nrp' => '87060531', 'email' => '87060531@bos.polri.go.id', 'roles' => [5], 'password' => '87060531'],
            ['nrp' => '78090907', 'email' => '78090907@bos.polri.go.id', 'roles' => [5], 'password' => '78090907'],
            ['nrp' => '88050638', 'email' => '88050638@bos.polri.go.id', 'roles' => [5], 'password' => '88050638'],
            ['nrp' => '97050375', 'email' => '97050375@bos.polri.go.id', 'roles' => [5], 'password' => '97050375'],
            ['nrp' => '85090647', 'email' => '85090647@bos.polri.go.id', 'roles' => [5], 'password' => '85090647'],
            ['nrp' => '82071322', 'email' => '82071322@bos.polri.go.id', 'roles' => [5], 'password' => '82071322'],
            ['nrp' => '87050082', 'email' => '87050082@bos.polri.go.id', 'roles' => [5], 'password' => '87050082'],
            ['nrp' => '89050209', 'email' => '89050209@bos.polri.go.id', 'roles' => [5], 'password' => '89050209'],
            ['nrp' => '84040733', 'email' => '84040733@bos.polri.go.id', 'roles' => [5], 'password' => '84040733'],
            ['nrp' => '84081248', 'email' => '84081248@bos.polri.go.id', 'roles' => [5], 'password' => '84081248'],
            ['nrp' => '85031472', 'email' => '85031472@bos.polri.go.id', 'roles' => [5], 'password' => '85031472'],
            ['nrp' => '82061195', 'email' => '82061195@bos.polri.go.id', 'roles' => [5], 'password' => '82061195'],
            ['nrp' => '82090996', 'email' => '82090996@bos.polri.go.id', 'roles' => [5], 'password' => '82090996'],
            ['nrp' => '83091277', 'email' => '83091277@bos.polri.go.id', 'roles' => [5], 'password' => '83091277'],
            ['nrp' => '78020763', 'email' => '78020763@bos.polri.go.id', 'roles' => [5], 'password' => '78020763'],
            ['nrp' => '85031967', 'email' => '85031967@bos.polri.go.id', 'roles' => [5], 'password' => '85031967'],
            ['nrp' => '97030309', 'email' => '97030309@bos.polri.go.id', 'roles' => [5], 'password' => '97030309'],
            ['nrp' => '86060935', 'email' => '86060935@bos.polri.go.id', 'roles' => [5], 'password' => '86060935'],
            ['nrp' => '80091246', 'email' => '80091246@bos.polri.go.id', 'roles' => [5], 'password' => '80091246'],
            ['nrp' => '82020865', 'email' => '82020865@bos.polri.go.id', 'roles' => [5], 'password' => '82020865'],
            ['nrp' => '79100736', 'email' => '79100736@bos.polri.go.id', 'roles' => [5], 'password' => '79100736'],
            ['nrp' => '85081844', 'email' => '85081844@bos.polri.go.id', 'roles' => [5], 'password' => '85081844'],
            ['nrp' => '89060102', 'email' => '89060102@bos.polri.go.id', 'roles' => [5], 'password' => '89060102'],
            ['nrp' => '80010642', 'email' => '80010642@bos.polri.go.id', 'roles' => [5], 'password' => '80010642'],
            ['nrp' => '85041513', 'email' => '85041513@bos.polri.go.id', 'roles' => [5], 'password' => '85041513'],
            ['nrp' => '85081365', 'email' => '85081365@bos.polri.go.id', 'roles' => [5], 'password' => '85081365'],
            ['nrp' => '86030561', 'email' => '86030561@bos.polri.go.id', 'roles' => [5], 'password' => '86030561'],
            ['nrp' => '97080862', 'email' => '97080862@bos.polri.go.id', 'roles' => [5], 'password' => '97080862'],
            ['nrp' => '96081084', 'email' => '96081084@bos.polri.go.id', 'roles' => [5], 'password' => '96081084'],
            ['nrp' => '96020599', 'email' => '96020599@bos.polri.go.id', 'roles' => [5], 'password' => '96020599'],
            ['nrp' => '89040411', 'email' => '89040411@bos.polri.go.id', 'roles' => [5], 'password' => '89040411'],
            ['nrp' => '85060065', 'email' => '85060065@bos.polri.go.id', 'roles' => [5], 'password' => '85060065'],
            ['nrp' => '91080159', 'email' => '91080159@bos.polri.go.id', 'roles' => [5], 'password' => '91080159'],
            ['nrp' => '80100273', 'email' => '80100273@bos.polri.go.id', 'roles' => [5], 'password' => '80100273'],
            ['nrp' => '80091236', 'email' => '80091236@bos.polri.go.id', 'roles' => [5], 'password' => '80091236'],
            ['nrp' => '92020009', 'email' => '92020009@bos.polri.go.id', 'roles' => [5], 'password' => '92020009'],
            ['nrp' => '77030765', 'email' => '77030765@bos.polri.go.id', 'roles' => [5], 'password' => '77030765'],
            ['nrp' => '85081225', 'email' => '85081225@bos.polri.go.id', 'roles' => [5], 'password' => '85081225'],
            ['nrp' => '85091725', 'email' => '85091725@bos.polri.go.id', 'roles' => [5], 'password' => '85091725'],
            ['nrp' => '96040640', 'email' => '96040640@bos.polri.go.id', 'roles' => [5], 'password' => '96040640'],
            ['nrp' => '84071451', 'email' => '84071451@bos.polri.go.id', 'roles' => [5], 'password' => '84071451'],
            ['nrp' => '86010739', 'email' => '86010739@bos.polri.go.id', 'roles' => [5], 'password' => '86010739'],
            ['nrp' => '90090246', 'email' => '90090246@bos.polri.go.id', 'roles' => [5], 'password' => '90090246'],
            ['nrp' => '00080112', 'email' => '00080112@bos.polri.go.id', 'roles' => [5], 'password' => '00080112'],
            ['nrp' => '93010247', 'email' => '93010247@bos.polri.go.id', 'roles' => [5], 'password' => '93010247'],
            ['nrp' => '94090679', 'email' => '94090679@bos.polri.go.id', 'roles' => [5], 'password' => '94090679'],
            ['nrp' => '80010593', 'email' => '80010593@bos.polri.go.id', 'roles' => [5], 'password' => '80010593'],
            ['nrp' => '80010593', 'email' => '80010593@bos.polri.go.id', 'roles' => [5], 'password' => '80010593'],
            ['nrp' => '87040552', 'email' => '87040552@bos.polri.go.id', 'roles' => [5], 'password' => '87040552'],
            ['nrp' => '83070466', 'email' => '83070466@bos.polri.go.id', 'roles' => [5], 'password' => '83070466'],
            //28 Juni 2021
            ['nrp' => '94010116', 'email' => '94010116@bos.polri.go.id', 'roles' => [5], 'password' => '94010116'],
            ['nrp' => '86011659', 'email' => '86011659@bos.polri.go.id', 'roles' => [5], 'password' => '86011659'],
            ['nrp' => '89090256', 'email' => '89090256@bos.polri.go.id', 'roles' => [5], 'password' => '89090256'],
            ['nrp' => '87101260', 'email' => '87101260@bos.polri.go.id', 'roles' => [5], 'password' => '87101260'],
            ['nrp' => '97120423', 'email' => '97120423@bos.polri.go.id', 'roles' => [5], 'password' => '97120423'],
            ['nrp' => '85071577', 'email' => '85071577@bos.polri.go.id', 'roles' => [5], 'password' => '85071577'],
            ['nrp' => '85052200', 'email' => '85052200@bos.polri.go.id', 'roles' => [5], 'password' => '85052200'],
            ['nrp' => '85121855', 'email' => '85121855@bos.polri.go.id', 'roles' => [5], 'password' => '85121855'],
            ['nrp' => '96070357', 'email' => '96070357@bos.polri.go.id', 'roles' => [5], 'password' => '96070357'],
            ['nrp' => '88050711', 'email' => '88050711@bos.polri.go.id', 'roles' => [5], 'password' => '88050711'],
            ['nrp' => '90020232', 'email' => '90020232@bos.polri.go.id', 'roles' => [5], 'password' => '90020232'],
            ['nrp' => '94101143', 'email' => '94101143@bos.polri.go.id', 'roles' => [5], 'password' => '94101143'],
            ['nrp' => '92010064', 'email' => '92010064@bos.polri.go.id', 'roles' => [5], 'password' => '92010064'],
            ['nrp' => '94070301', 'email' => '94070301@bos.polri.go.id', 'roles' => [5], 'password' => '94070301'],
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
