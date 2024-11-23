<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaAcehSeeder extends Seeder
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
            [  'nrp' =>'81110789', 'email' => '81110789@bos.polri.go.id', 'roles' => [5],  'password' => '81110789' ],
[  'nrp' =>'87060454', 'email' => '87060454@bos.polri.go.id', 'roles' => [5],  'password' => '87060454' ],
[  'nrp' =>'87060454', 'email' => '87060454@bos.polri.go.id', 'roles' => [5],  'password' => '87060454' ],
[  'nrp' =>'86071729', 'email' => '86071729@bos.polri.go.id', 'roles' => [5],  'password' => '86071729' ],
[  'nrp' =>'87070074', 'email' => '87070074@bos.polri.go.id', 'roles' => [5],  'password' => '87070074' ],
[  'nrp' =>'86120648', 'email' => '86120648@bos.polri.go.id', 'roles' => [5],  'password' => '86120648' ],
[  'nrp' =>'87041679', 'email' => '87041679@bos.polri.go.id', 'roles' => [5],  'password' => '87041679' ],
[  'nrp' =>'86091667', 'email' => '86091667@bos.polri.go.id', 'roles' => [5],  'password' => '86091667' ],
[  'nrp' =>'89069442', 'email' => '89069442@bos.polri.go.id', 'roles' => [5],  'password' => '89069442' ],
[  'nrp' =>'86111189', 'email' => '86111189@bos.polri.go.id', 'roles' => [5],  'password' => '86111189' ],
[  'nrp' =>'85061696', 'email' => '85061696@bos.polri.go.id', 'roles' => [5],  'password' => '85061696' ],
[  'nrp' =>'85071116', 'email' => '85071116@bos.polri.go.id', 'roles' => [5],  'password' => '85071116' ],
[  'nrp' =>'89060252', 'email' => '89060252@bos.polri.go.id', 'roles' => [5],  'password' => '89060252' ],
[  'nrp' =>'86051296', 'email' => '86051296@bos.polri.go.id', 'roles' => [5],  'password' => '86051296' ],
[  'nrp' =>'89090629', 'email' => '89090629@bos.polri.go.id', 'roles' => [5],  'password' => '89090629' ],
[  'nrp' =>'92040091', 'email' => '92040091@bos.polri.go.id', 'roles' => [5],  'password' => '92040091' ],
[  'nrp' =>'93040730', 'email' => '93040730@bos.polri.go.id', 'roles' => [5],  'password' => '93040730' ],
[  'nrp' =>'95100299', 'email' => '95100299@bos.polri.go.id', 'roles' => [5],  'password' => '95100299' ],
[  'nrp' =>'96110402', 'email' => '96110402@bos.polri.go.id', 'roles' => [5],  'password' => '96110402' ],
[  'nrp' =>'97010316', 'email' => '97010316@bos.polri.go.id', 'roles' => [5],  'password' => '97010316' ],
[  'nrp' =>'00010005', 'email' => '00010005@bos.polri.go.id', 'roles' => [5],  'password' => '00010005' ],
[  'nrp' =>'96120364', 'email' => '96120364@bos.polri.go.id', 'roles' => [5],  'password' => '96120364' ],
[  'nrp' =>'86081045', 'email' => '86081045@bos.polri.go.id', 'roles' => [5],  'password' => '86081045' ],
[  'nrp' =>'96100735', 'email' => '96100735@bos.polri.go.id', 'roles' => [5],  'password' => '96100735' ],
[  'nrp' =>'86031687', 'email' => '86031687@bos.polri.go.id', 'roles' => [5],  'password' => '86031687' ],
[  'nrp' =>'86041027', 'email' => '86041027@bos.polri.go.id', 'roles' => [5],  'password' => '86041027' ],
[  'nrp' =>'95100778', 'email' => '95100778@bos.polri.go.id', 'roles' => [5],  'password' => '95100778' ],
[  'nrp' =>'84041910', 'email' => '84041910@bos.polri.go.id', 'roles' => [5],  'password' => '84041910' ],
[  'nrp' =>'86050796', 'email' => '86050796@bos.polri.go.id', 'roles' => [5],  'password' => '86050796' ],
[  'nrp' =>'87120966', 'email' => '87120966@bos.polri.go.id', 'roles' => [5],  'password' => '87120966' ],
[  'nrp' =>'87030964', 'email' => '87030964@bos.polri.go.id', 'roles' => [5],  'password' => '87030964' ],
[  'nrp' =>'89060653', 'email' => '89060653@bos.polri.go.id', 'roles' => [5],  'password' => '89060653' ],
[  'nrp' =>'87050197', 'email' => '87050197@bos.polri.go.id', 'roles' => [5],  'password' => '87050197' ],
[  'nrp' =>'86010675', 'email' => '86010675@bos.polri.go.id', 'roles' => [5],  'password' => '86010675' ],
[  'nrp' =>'84111231', 'email' => '84111231@bos.polri.go.id', 'roles' => [5],  'password' => '84111231' ],
[  'nrp' =>'86100691', 'email' => '86100691@bos.polri.go.id', 'roles' => [5],  'password' => '86100691' ],
[  'nrp' =>'83080373', 'email' => '83080373@bos.polri.go.id', 'roles' => [5],  'password' => '83080373' ],
[  'nrp' =>'93110384', 'email' => '93110384@bos.polri.go.id', 'roles' => [5],  'password' => '93110384' ],
[  'nrp' =>'86040803', 'email' => '86040803@bos.polri.go.id', 'roles' => [5],  'password' => '86040803' ],
[  'nrp' =>'85121366', 'email' => '85121366@bos.polri.go.id', 'roles' => [5],  'password' => '85121366' ],
[  'nrp' =>'81090195', 'email' => '81090195@bos.polri.go.id', 'roles' => [5],  'password' => '81090195' ],
[  'nrp' =>'88060434', 'email' => '88060434@bos.polri.go.id', 'roles' => [5],  'password' => '88060434' ],
[  'nrp' =>'85121133', 'email' => '85121133@bos.polri.go.id', 'roles' => [5],  'password' => '85121133' ],
[  'nrp' =>'86070770', 'email' => '86070770@bos.polri.go.id', 'roles' => [5],  'password' => '86070770' ],
[  'nrp' =>'92050254', 'email' => '92050254@bos.polri.go.id', 'roles' => [5],  'password' => '92050254' ],
[  'nrp' =>'93050124', 'email' => '93050124@bos.polri.go.id', 'roles' => [5],  'password' => '93050124' ],
[  'nrp' =>'85061051', 'email' => '85061051@bos.polri.go.id', 'roles' => [5],  'password' => '85061051' ],
[  'nrp' =>'92080606', 'email' => '92080606@bos.polri.go.id', 'roles' => [5],  'password' => '92080606' ],
[  'nrp' =>'86041828', 'email' => '86041828@bos.polri.go.id', 'roles' => [5],  'password' => '86041828' ],
[  'nrp' =>'86041584', 'email' => '86041584@bos.polri.go.id', 'roles' => [5],  'password' => '86041584' ],
[  'nrp' =>'8511165', 'email' => '8511165@bos.polri.go.id', 'roles' => [5],  'password' => '8511165' ],
[  'nrp' =>'86010952', 'email' => '86010952@bos.polri.go.id', 'roles' => [5],  'password' => '86010952' ],
[  'nrp' =>'85061413', 'email' => '85061413@bos.polri.go.id', 'roles' => [5],  'password' => '85061413' ],
[  'nrp' =>'88061023', 'email' => '88061023@bos.polri.go.id', 'roles' => [5],  'password' => '88061023' ],
[  'nrp' =>'79090531', 'email' => '79090531@bos.polri.go.id', 'roles' => [5],  'password' => '79090531' ],
[  'nrp' =>'86031091', 'email' => '86031091@bos.polri.go.id', 'roles' => [5],  'password' => '86031091' ],
[  'nrp' =>'67050445', 'email' => '67050445@bos.polri.go.id', 'roles' => [5],  'password' => '67050445' ],
[  'nrp' =>'88040049', 'email' => '88040049@bos.polri.go.id', 'roles' => [5],  'password' => '88040049' ],
[  'nrp' =>'87081016', 'email' => '87081016@bos.polri.go.id', 'roles' => [5],  'password' => '87081016' ],
[  'nrp' =>'86120548', 'email' => '86120548@bos.polri.go.id', 'roles' => [5],  'password' => '86120548' ],
[  'nrp' =>'85071888', 'email' => '85071888@bos.polri.go.id', 'roles' => [5],  'password' => '85071888' ],
[  'nrp' =>'88070195', 'email' => '88070195@bos.polri.go.id', 'roles' => [5],  'password' => '88070195' ],
[  'nrp' =>'89090244', 'email' => '89090244@bos.polri.go.id', 'roles' => [5],  'password' => '89090244' ],
[  'nrp' =>'85101947', 'email' => '85101947@bos.polri.go.id', 'roles' => [5],  'password' => '85101947' ],
[  'nrp' =>'86020799', 'email' => '86020799@bos.polri.go.id', 'roles' => [5],  'password' => '86020799' ],
[  'nrp' =>'86110418', 'email' => '86110418@bos.polri.go.id', 'roles' => [5],  'password' => '86110418' ],
[  'nrp' =>'85011066', 'email' => '85011066@bos.polri.go.id', 'roles' => [5],  'password' => '85011066' ],
[  'nrp' =>'88030946', 'email' => '88030946@bos.polri.go.id', 'roles' => [5],  'password' => '88030946' ],
[  'nrp' =>'88041048', 'email' => '88041048@bos.polri.go.id', 'roles' => [5],  'password' => '88041048' ],
[  'nrp' =>'85070310', 'email' => '85070310@bos.polri.go.id', 'roles' => [5],  'password' => '85070310' ],
[  'nrp' =>'86100869', 'email' => '86100869@bos.polri.go.id', 'roles' => [5],  'password' => '86100869' ],
[  'nrp' =>'84061630', 'email' => '84061630@bos.polri.go.id', 'roles' => [5],  'password' => '84061630' ],
[  'nrp' =>'87071153', 'email' => '87071153@bos.polri.go.id', 'roles' => [5],  'password' => '87071153' ],
[  'nrp' =>'85051718', 'email' => '85051718@bos.polri.go.id', 'roles' => [5],  'password' => '85051718' ],
[  'nrp' =>'85011635', 'email' => '85011635@bos.polri.go.id', 'roles' => [5],  'password' => '85011635' ],
[  'nrp' =>'87120269', 'email' => '87120269@bos.polri.go.id', 'roles' => [5],  'password' => '87120269' ],
[  'nrp' =>'85121070', 'email' => '85121070@bos.polri.go.id', 'roles' => [5],  'password' => '85121070' ],
[  'nrp' =>'96090010', 'email' => '96090010@bos.polri.go.id', 'roles' => [5],  'password' => '96090010' ],
[  'nrp' =>'87081545', 'email' => '87081545@bos.polri.go.id', 'roles' => [5],  'password' => '87081545' ],
[  'nrp' =>'85101073', 'email' => '85101073@bos.polri.go.id', 'roles' => [5],  'password' => '85101073' ],
[  'nrp' =>'90010267', 'email' => '90010267@bos.polri.go.id', 'roles' => [5],  'password' => '90010267' ],
[  'nrp' =>'81121218', 'email' => '81121218@bos.polri.go.id', 'roles' => [5],  'password' => '81121218' ],
[  'nrp' =>'88120707', 'email' => '88120707@bos.polri.go.id', 'roles' => [5],  'password' => '88120707' ],
[  'nrp' =>'96020661', 'email' => '96020661@bos.polri.go.id', 'roles' => [5],  'password' => '96020661' ],
[  'nrp' =>'79051968', 'email' => '79051968@bos.polri.go.id', 'roles' => [5],  'password' => '79051968' ],
[  'nrp' =>'82020491', 'email' => '82020491@bos.polri.go.id', 'roles' => [5],  'password' => '82020491' ],
[  'nrp' =>'80031035', 'email' => '80031035@bos.polri.go.id', 'roles' => [5],  'password' => '80031035' ],
[  'nrp' =>'82020399', 'email' => '82020399@bos.polri.go.id', 'roles' => [5],  'password' => '82020399' ],
[  'nrp' =>'85021349', 'email' => '85021349@bos.polri.go.id', 'roles' => [5],  'password' => '85021349' ],
[  'nrp' =>'87040351', 'email' => '87040351@bos.polri.go.id', 'roles' => [5],  'password' => '87040351' ],
[  'nrp' =>'85111674', 'email' => '85111674@bos.polri.go.id', 'roles' => [5],  'password' => '85111674' ],
[  'nrp' =>'85102005', 'email' => '85102005@bos.polri.go.id', 'roles' => [5],  'password' => '85102005' ],
[  'nrp' =>'86061189', 'email' => '86061189@bos.polri.go.id', 'roles' => [5],  'password' => '86061189' ],
[  'nrp' =>'00010278', 'email' => '00010278@bos.polri.go.id', 'roles' => [5],  'password' => '00010278' ],
[  'nrp' =>'00060310', 'email' => '00060310@bos.polri.go.id', 'roles' => [5],  'password' => '00060310' ],
[  'nrp' =>'00080199', 'email' => '00080199@bos.polri.go.id', 'roles' => [5],  'password' => '00080199' ],
[  'nrp' =>'00050447', 'email' => '00050447@bos.polri.go.id', 'roles' => [5],  'password' => '00050447' ],
[  'nrp' =>'00030517', 'email' => '00030517@bos.polri.go.id', 'roles' => [5],  'password' => '00030517' ],
[  'nrp' =>'86060938', 'email' => '86060938@bos.polri.go.id', 'roles' => [5],  'password' => '86060938' ],
[  'nrp' =>'5101064', 'email' => '5101064@bos.polri.go.id', 'roles' => [5],  'password' => '5101064' ],
[  'nrp' =>'5101064', 'email' => '5101064@bos.polri.go.id', 'roles' => [5],  'password' => '5101064' ],
[  'nrp' =>'89060484', 'email' => '89060484@bos.polri.go.id', 'roles' => [5],  'password' => '89060484' ],
[  'nrp' =>'85051083', 'email' => '85051083@bos.polri.go.id', 'roles' => [5],  'password' => '85051083' ],
[  'nrp' =>'85011227', 'email' => '85011227@bos.polri.go.id', 'roles' => [5],  'password' => '85011227' ],
[  'nrp' =>'85071533', 'email' => '85071533@bos.polri.go.id', 'roles' => [5],  'password' => '85071533' ],
[  'nrp' =>'86120626', 'email' => '86120626@bos.polri.go.id', 'roles' => [5],  'password' => '86120626' ],
[  'nrp' =>'83100211', 'email' => '83100211@bos.polri.go.id', 'roles' => [5],  'password' => '83100211' ],
[  'nrp' =>'87050838', 'email' => '87050838@bos.polri.go.id', 'roles' => [5],  'password' => '87050838' ],
[  'nrp' =>'88080089', 'email' => '88080089@bos.polri.go.id', 'roles' => [5],  'password' => '88080089' ],
[  'nrp' =>'95050428', 'email' => '95050428@bos.polri.go.id', 'roles' => [5],  'password' => '95050428' ],
[  'nrp' =>'85081244', 'email' => '85081244@bos.polri.go.id', 'roles' => [5],  'password' => '85081244' ],
[  'nrp' =>'87051761', 'email' => '87051761@bos.polri.go.id', 'roles' => [5],  'password' => '87051761' ],
[  'nrp' =>'82100863', 'email' => '82100863@bos.polri.go.id', 'roles' => [5],  'password' => '82100863' ],
[  'nrp' =>'85050770', 'email' => '85050770@bos.polri.go.id', 'roles' => [5],  'password' => '85050770' ],
[  'nrp' =>'93070461', 'email' => '93070461@bos.polri.go.id', 'roles' => [5],  'password' => '93070461' ],
[  'nrp' =>'00090255', 'email' => '00090255@bos.polri.go.id', 'roles' => [5],  'password' => '00090255' ],
[  'nrp' =>'98060575', 'email' => '98060575@bos.polri.go.id', 'roles' => [5],  'password' => '98060575' ],
[  'nrp' =>'80040345', 'email' => '80040345@bos.polri.go.id', 'roles' => [5],  'password' => '80040345' ],
[  'nrp' =>'83121266', 'email' => '83121266@bos.polri.go.id', 'roles' => [5],  'password' => '83121266' ],
[  'nrp' =>'91010048', 'email' => '91010048@bos.polri.go.id', 'roles' => [5],  'password' => '91010048' ],
[  'nrp' =>'84121665', 'email' => '84121665@bos.polri.go.id', 'roles' => [5],  'password' => '84121665' ],
[  'nrp' =>'87020130', 'email' => '87020130@bos.polri.go.id', 'roles' => [5],  'password' => '87020130' ],
[  'nrp' =>'85070671', 'email' => '85070671@bos.polri.go.id', 'roles' => [5],  'password' => '85070671' ],
[  'nrp' =>'86071729', 'email' => '86071729@bos.polri.go.id', 'roles' => [5],  'password' => '86071729' ],
[  'nrp' =>'86090714', 'email' => '86090714@bos.polri.go.id', 'roles' => [5],  'password' => '86090714' ],
[  'nrp' =>'86071169', 'email' => '86071169@bos.polri.go.id', 'roles' => [5],  'password' => '86071169' ],
[  'nrp' =>'86011210', 'email' => '86011210@bos.polri.go.id', 'roles' => [5],  'password' => '86011210' ],
[  'nrp' =>'86091281', 'email' => '86091281@bos.polri.go.id', 'roles' => [5],  'password' => '86091281' ],
[  'nrp' =>'84110811', 'email' => '84110811@bos.polri.go.id', 'roles' => [5],  'password' => '84110811' ],
[  'nrp' =>'84041410', 'email' => '84041410@bos.polri.go.id', 'roles' => [5],  'password' => '84041410' ],
[  'nrp' =>'85121364', 'email' => '85121364@bos.polri.go.id', 'roles' => [5],  'password' => '85121364' ],
[  'nrp' =>'86121715', 'email' => '86121715@bos.polri.go.id', 'roles' => [5],  'password' => '86121715' ],
[  'nrp' =>'86061189', 'email' => '86061189@bos.polri.go.id', 'roles' => [5],  'password' => '86061189' ],
[  'nrp' =>'89060442', 'email' => '89060442@bos.polri.go.id', 'roles' => [5],  'password' => '89060442' ],
[  'nrp' =>'85061696', 'email' => '85061696@bos.polri.go.id', 'roles' => [5],  'password' => '85061696' ],
[  'nrp' =>'84121665', 'email' => '84121665@bos.polri.go.id', 'roles' => [5],  'password' => '84121665' ],
[  'nrp' =>'87020130', 'email' => '87020130@bos.polri.go.id', 'roles' => [5],  'password' => '87020130' ],
[  'nrp' =>'88100153', 'email' => '88100153@bos.polri.go.id', 'roles' => [5],  'password' => '88100153' ],
[  'nrp' =>'78110638', 'email' => '78110638@bos.polri.go.id', 'roles' => [5],  'password' => '78110638' ],
[  'nrp' =>'82041371', 'email' => '82041371@bos.polri.go.id', 'roles' => [5],  'password' => '82041371' ],
[  'nrp' =>'87080867', 'email' => '87080867@bos.polri.go.id', 'roles' => [5],  'password' => '87080867' ],
[  'nrp' =>'81040906', 'email' => '81040906@bos.polri.go.id', 'roles' => [5],  'password' => '81040906' ],
[  'nrp' =>'81061287', 'email' => '81061287@bos.polri.go.id', 'roles' => [5],  'password' => '81061287' ],
[  'nrp' =>'63050152', 'email' => '63050152@bos.polri.go.id', 'roles' => [5],  'password' => '63050152' ],
[  'nrp' =>'84070393', 'email' => '84070393@bos.polri.go.id', 'roles' => [5],  'password' => '84070393' ],
[  'nrp' =>'87090731', 'email' => '87090731@bos.polri.go.id', 'roles' => [5],  'password' => '87090731' ],
[  'nrp' =>'81030039', 'email' => '81030039@bos.polri.go.id', 'roles' => [5],  'password' => '81030039' ],
[  'nrp' =>'88050241', 'email' => '88050241@bos.polri.go.id', 'roles' => [5],  'password' => '88050241' ],
[  'nrp' =>'86121250', 'email' => '86121250@bos.polri.go.id', 'roles' => [5],  'password' => '86121250' ],
[  'nrp' =>'84051547', 'email' => '84051547@bos.polri.go.id', 'roles' => [5],  'password' => '84051547' ],
[  'nrp' =>'87021155', 'email' => '87021155@bos.polri.go.id', 'roles' => [5],  'password' => '87021155' ],
[  'nrp' =>'86060351', 'email' => '86060351@bos.polri.go.id', 'roles' => [5],  'password' => '86060351' ],
[  'nrp' =>'93070533', 'email' => '93070533@bos.polri.go.id', 'roles' => [5],  'password' => '93070533' ],
[  'nrp' =>'86110412', 'email' => '86110412@bos.polri.go.id', 'roles' => [5],  'password' => '86110412' ],
[  'nrp' =>'78070898', 'email' => '78070898@bos.polri.go.id', 'roles' => [5],  'password' => '78070898' ],
[  'nrp' =>'84051735', 'email' => '84051735@bos.polri.go.id', 'roles' => [5],  'password' => '84051735' ],
[  'nrp' =>'96030458', 'email' => '96030458@bos.polri.go.id', 'roles' => [5],  'password' => '96030458' ],

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
