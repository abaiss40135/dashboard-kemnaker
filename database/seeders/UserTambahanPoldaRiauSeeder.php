<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTambahanPoldaRiauSeeder extends Seeder
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
            [  'nrp' =>'93110839', 'email' => '93110839@bos.polri.go.id', 'roles' => [5],  'password' => '93110839' ],
            [  'nrp' =>'87020695', 'email' => '87020695@bos.polri.go.id', 'roles' => [5],  'password' => '87020695' ],
            [  'nrp' =>'95030866', 'email' => '95030866@bos.polri.go.id', 'roles' => [5],  'password' => '95030866' ],
            [  'nrp' =>'89060648', 'email' => '89060648@bos.polri.go.id', 'roles' => [5],  'password' => '89060648' ],
            [  'nrp' =>'84080566', 'email' => '84080566@bos.polri.go.id', 'roles' => [5],  'password' => '84080566' ],
            [  'nrp' =>'81110918', 'email' => '81110918@bos.polri.go.id', 'roles' => [5],  'password' => '81110918' ],
            [  'nrp' =>'82110501', 'email' => '82110501@bos.polri.go.id', 'roles' => [5],  'password' => '82110501' ],
            [  'nrp' =>'85010606', 'email' => '85010606@bos.polri.go.id', 'roles' => [5],  'password' => '85010606' ],
            [  'nrp' =>'80051075', 'email' => '80051075@bos.polri.go.id', 'roles' => [5],  'password' => '80051075' ],
            [  'nrp' =>'88090324', 'email' => '88090324@bos.polri.go.id', 'roles' => [5],  'password' => '88090324' ],
            [  'nrp' =>'90040341', 'email' => '90040341@bos.polri.go.id', 'roles' => [5],  'password' => '90040341' ],
            [  'nrp' =>'86040904', 'email' => '86040904@bos.polri.go.id', 'roles' => [5],  'password' => '86040904' ],
[  'nrp' =>'76120837', 'email' => '76120837@bos.polri.go.id', 'roles' => [5],  'password' => '76120837' ],
[  'nrp' =>'83100130', 'email' => '83100130@bos.polri.go.id', 'roles' => [5],  'password' => '83100130' ],
[  'nrp' =>'82060192', 'email' => '82060192@bos.polri.go.id', 'roles' => [5],  'password' => '82060192' ],
[  'nrp' =>'84120806', 'email' => '84120806@bos.polri.go.id', 'roles' => [5],  'password' => '84120806' ],
[  'nrp' =>'86100657', 'email' => '86100657@bos.polri.go.id', 'roles' => [5],  'password' => '86100657' ],
[  'nrp' =>'88070853', 'email' => '88070853@bos.polri.go.id', 'roles' => [5],  'password' => '88070853' ],
[  'nrp' =>'87120930', 'email' => '87120930@bos.polri.go.id', 'roles' => [5],  'password' => '87120930' ],
[  'nrp' =>'87071603', 'email' => '87071603@bos.polri.go.id', 'roles' => [5],  'password' => '87071603' ],
[  'nrp' =>'86071571', 'email' => '86071571@bos.polri.go.id', 'roles' => [5],  'password' => '86071571' ],
[  'nrp' =>'88030962', 'email' => '88030962@bos.polri.go.id', 'roles' => [5],  'password' => '88030962' ],
[  'nrp' =>'84051414', 'email' => '84051414@bos.polri.go.id', 'roles' => [5],  'password' => '84051414' ],
[  'nrp' =>'89070490', 'email' => '89070490@bos.polri.go.id', 'roles' => [5],  'password' => '89070490' ],
[  'nrp' =>'82060921', 'email' => '82060921@bos.polri.go.id', 'roles' => [5],  'password' => '82060921' ],
[  'nrp' =>'85121744', 'email' => '85121744@bos.polri.go.id', 'roles' => [5],  'password' => '85121744' ],
[  'nrp' =>'86060717', 'email' => '86060717@bos.polri.go.id', 'roles' => [5],  'password' => '86060717' ],
[  'nrp' =>'82101185', 'email' => '82101185@bos.polri.go.id', 'roles' => [5],  'password' => '82101185' ],
[  'nrp' =>'83020932', 'email' => '83020932@bos.polri.go.id', 'roles' => [5],  'password' => '83020932' ],
[  'nrp' =>'70030374', 'email' => '70030374@bos.polri.go.id', 'roles' => [5],  'password' => '70030374' ],
[  'nrp' =>'82070852', 'email' => '82070852@bos.polri.go.id', 'roles' => [5],  'password' => '82070852' ],
[  'nrp' =>'85060923', 'email' => '85060923@bos.polri.go.id', 'roles' => [5],  'password' => '85060923' ],
[  'nrp' =>'83100596', 'email' => '83100596@bos.polri.go.id', 'roles' => [5],  'password' => '83100596' ],
[  'nrp' =>'87080785', 'email' => '87080785@bos.polri.go.id', 'roles' => [5],  'password' => '87080785' ],
[  'nrp' =>'87070541', 'email' => '87070541@bos.polri.go.id', 'roles' => [5],  'password' => '87070541' ],
[  'nrp' =>'79040632', 'email' => '79040632@bos.polri.go.id', 'roles' => [5],  'password' => '79040632' ],
[  'nrp' =>'87090792', 'email' => '87090792@bos.polri.go.id', 'roles' => [5],  'password' => '87090792' ],
[  'nrp' =>'82060806', 'email' => '82060806@bos.polri.go.id', 'roles' => [5],  'password' => '82060806' ],
[  'nrp' =>'85100720', 'email' => '85100720@bos.polri.go.id', 'roles' => [5],  'password' => '85100720' ],
[  'nrp' =>'85081113', 'email' => '85081113@bos.polri.go.id', 'roles' => [5],  'password' => '85081113' ],
[  'nrp' =>'93120753', 'email' => '93120753@bos.polri.go.id', 'roles' => [5],  'password' => '93120753' ],
[  'nrp' =>'94060051', 'email' => '94060051@bos.polri.go.id', 'roles' => [5],  'password' => '94060051' ],
[  'nrp' =>'69080431', 'email' => '69080431@bos.polri.go.id', 'roles' => [5],  'password' => '69080431' ],
[  'nrp' =>'84121215', 'email' => '84121215@bos.polri.go.id', 'roles' => [5],  'password' => '84121215' ],
[  'nrp' =>'86020422', 'email' => '86020422@bos.polri.go.id', 'roles' => [5],  'password' => '86020422' ],
[  'nrp' =>'74030240', 'email' => '74030240@bos.polri.go.id', 'roles' => [5],  'password' => '74030240' ],
[  'nrp' =>'85121127', 'email' => '85121127@bos.polri.go.id', 'roles' => [5],  'password' => '85121127' ],
[  'nrp' =>'84100307', 'email' => '84100307@bos.polri.go.id', 'roles' => [5],  'password' => '84100307' ],
[  'nrp' =>'79080608', 'email' => '79080608@bos.polri.go.id', 'roles' => [5],  'password' => '79080608' ],
[  'nrp' =>'87070994', 'email' => '87070994@bos.polri.go.id', 'roles' => [5],  'password' => '87070994' ],
[  'nrp' =>'86061879', 'email' => '86061879@bos.polri.go.id', 'roles' => [5],  'password' => '86061879' ],
[  'nrp' =>'87070606', 'email' => '87070606@bos.polri.go.id', 'roles' => [5],  'password' => '87070606' ],
[  'nrp' =>'85101454', 'email' => '85101454@bos.polri.go.id', 'roles' => [5],  'password' => '85101454' ],
[  'nrp' =>'89090241', 'email' => '89090241@bos.polri.go.id', 'roles' => [5],  'password' => '89090241' ],
[  'nrp' =>'82110745', 'email' => '82110745@bos.polri.go.id', 'roles' => [5],  'password' => '82110745' ],
[  'nrp' =>'82110685', 'email' => '82110685@bos.polri.go.id', 'roles' => [5],  'password' => '82110685' ],
[  'nrp' =>'85070284', 'email' => '85070284@bos.polri.go.id', 'roles' => [5],  'password' => '85070284' ],
[  'nrp' =>'79081048', 'email' => '79081048@bos.polri.go.id', 'roles' => [5],  'password' => '79081048' ],
[  'nrp' =>'84081233', 'email' => '84081233@bos.polri.go.id', 'roles' => [5],  'password' => '84081233' ],
[  'nrp' =>'86091819', 'email' => '86091819@bos.polri.go.id', 'roles' => [5],  'password' => '86091819' ],
[  'nrp' =>'86071373', 'email' => '86071373@bos.polri.go.id', 'roles' => [5],  'password' => '86071373' ],
[  'nrp' =>'79051783', 'email' => '79051783@bos.polri.go.id', 'roles' => [5],  'password' => '79051783' ],
[  'nrp' =>'83070871', 'email' => '83070871@bos.polri.go.id', 'roles' => [5],  'password' => '83070871' ],
[  'nrp' =>'86071305', 'email' => '86071305@bos.polri.go.id', 'roles' => [5],  'password' => '86071305' ],
[  'nrp' =>'85121127', 'email' => '85121127@bos.polri.go.id', 'roles' => [5],  'password' => '85121127' ],
[  'nrp' =>'84020563', 'email' => '84020563@bos.polri.go.id', 'roles' => [5],  'password' => '84020563' ],
[  'nrp' =>'83051331', 'email' => '83051331@bos.polri.go.id', 'roles' => [5],  'password' => '83051331' ],
[  'nrp' =>'83070871', 'email' => '83070871@bos.polri.go.id', 'roles' => [5],  'password' => '83070871' ],
[  'nrp' =>'79071201', 'email' => '79071201@bos.polri.go.id', 'roles' => [5],  'password' => '79071201' ],
[  'nrp' =>'88040318', 'email' => '88040318@bos.polri.go.id', 'roles' => [5],  'password' => '88040318' ],
[  'nrp' =>'73100531', 'email' => '73100531@bos.polri.go.id', 'roles' => [5],  'password' => '73100531' ],
[  'nrp' =>'85050985', 'email' => '85050985@bos.polri.go.id', 'roles' => [5],  'password' => '85050985' ],
[  'nrp' =>'79081048', 'email' => '79081048@bos.polri.go.id', 'roles' => [5],  'password' => '79081048' ],
[  'nrp' =>'84120222', 'email' => '84120222@bos.polri.go.id', 'roles' => [5],  'password' => '84120222' ],
[  'nrp' =>'85120480', 'email' => '85120480@bos.polri.go.id', 'roles' => [5],  'password' => '85120480' ],
[  'nrp' =>'86061399', 'email' => '86061399@bos.polri.go.id', 'roles' => [5],  'password' => '86061399' ],
[  'nrp' =>'82110849', 'email' => '82110849@bos.polri.go.id', 'roles' => [5],  'password' => '82110849' ],
[  'nrp' =>'93050854', 'email' => '93050854@bos.polri.go.id', 'roles' => [5],  'password' => '93050854' ],
[  'nrp' =>'84101221', 'email' => '84101221@bos.polri.go.id', 'roles' => [5],  'password' => '84101221' ],
[  'nrp' =>'85020318', 'email' => '85020318@bos.polri.go.id', 'roles' => [5],  'password' => '85020318' ],
[  'nrp' =>'84100422', 'email' => '84100422@bos.polri.go.id', 'roles' => [5],  'password' => '84100422' ],
[  'nrp' =>'86041304', 'email' => '86041304@bos.polri.go.id', 'roles' => [5],  'password' => '86041304' ],
[  'nrp' =>'85091888', 'email' => '85091888@bos.polri.go.id', 'roles' => [5],  'password' => '85091888' ],
[  'nrp' =>'75040234', 'email' => '75040234@bos.polri.go.id', 'roles' => [5],  'password' => '75040234' ],
[  'nrp' =>'86071305', 'email' => '86071305@bos.polri.go.id', 'roles' => [5],  'password' => '86071305' ],
[  'nrp' =>'85110897', 'email' => '85110897@bos.polri.go.id', 'roles' => [5],  'password' => '85110897' ],
[  'nrp' =>'80081352', 'email' => '80081352@bos.polri.go.id', 'roles' => [5],  'password' => '80081352' ],
[  'nrp' =>'76120601', 'email' => '76120601@bos.polri.go.id', 'roles' => [5],  'password' => '76120601' ],
[  'nrp' =>'83031177', 'email' => '83031177@bos.polri.go.id', 'roles' => [5],  'password' => '83031177' ],
[  'nrp' =>'83041234', 'email' => '83041234@bos.polri.go.id', 'roles' => [5],  'password' => '83041234' ],
[  'nrp' =>'86031129', 'email' => '86031129@bos.polri.go.id', 'roles' => [5],  'password' => '86031129' ],
[  'nrp' =>'79041052', 'email' => '79041052@bos.polri.go.id', 'roles' => [5],  'password' => '79041052' ],
[  'nrp' =>'82030433', 'email' => '82030433@bos.polri.go.id', 'roles' => [5],  'password' => '82030433' ],
[  'nrp' =>'72110070', 'email' => '72110070@bos.polri.go.id', 'roles' => [5],  'password' => '72110070' ],
[  'nrp' =>'77081091', 'email' => '77081091@bos.polri.go.id', 'roles' => [5],  'password' => '77081091' ],
[  'nrp' =>'83060322', 'email' => '83060322@bos.polri.go.id', 'roles' => [5],  'password' => '83060322' ],
[  'nrp' =>'80060574', 'email' => '80060574@bos.polri.go.id', 'roles' => [5],  'password' => '80060574' ],
[  'nrp' =>'82051397', 'email' => '82051397@bos.polri.go.id', 'roles' => [5],  'password' => '82051397' ],
[  'nrp' =>'88020301', 'email' => '88020301@bos.polri.go.id', 'roles' => [5],  'password' => '88020301' ],
[  'nrp' =>'76030167', 'email' => '76030167@bos.polri.go.id', 'roles' => [5],  'password' => '76030167' ],
[  'nrp' =>'85101454', 'email' => '85101454@bos.polri.go.id', 'roles' => [5],  'password' => '85101454' ],
[  'nrp' =>'85071528', 'email' => '85071528@bos.polri.go.id', 'roles' => [5],  'password' => '85071528' ],
[  'nrp' =>'86061879', 'email' => '86061879@bos.polri.go.id', 'roles' => [5],  'password' => '86061879' ],
[  'nrp' =>'79090501', 'email' => '79090501@bos.polri.go.id', 'roles' => [5],  'password' => '79090501' ],
[  'nrp' =>'79090501', 'email' => '79090501@bos.polri.go.id', 'roles' => [5],  'password' => '79090501' ],
[  'nrp' =>'82090226', 'email' => '82090226@bos.polri.go.id', 'roles' => [5],  'password' => '82090226' ],
[  'nrp' =>'77051016', 'email' => '77051016@bos.polri.go.id', 'roles' => [5],  'password' => '77051016' ],
[  'nrp' =>'86100150', 'email' => '86100150@bos.polri.go.id', 'roles' => [5],  'password' => '86100150' ],
[  'nrp' =>'85121165', 'email' => '85121165@bos.polri.go.id', 'roles' => [5],  'password' => '85121165' ],
[  'nrp' =>'75010479', 'email' => '75010479@bos.polri.go.id', 'roles' => [5],  'password' => '75010479' ],
[  'nrp' =>'73110071', 'email' => '73110071@bos.polri.go.id', 'roles' => [5],  'password' => '73110071' ],
[  'nrp' =>'76050345', 'email' => '76050345@bos.polri.go.id', 'roles' => [5],  'password' => '76050345' ],
[  'nrp' =>'75061043', 'email' => '75061043@bos.polri.go.id', 'roles' => [5],  'password' => '75061043' ],
[  'nrp' =>'79051617', 'email' => '79051617@bos.polri.go.id', 'roles' => [5],  'password' => '79051617' ],
[  'nrp' =>'82041395', 'email' => '82041395@bos.polri.go.id', 'roles' => [5],  'password' => '82041395' ],
[  'nrp' =>'81060748', 'email' => '81060748@bos.polri.go.id', 'roles' => [5],  'password' => '81060748' ],
[  'nrp' =>'83070761', 'email' => '83070761@bos.polri.go.id', 'roles' => [5],  'password' => '83070761' ],
[  'nrp' =>'87020780', 'email' => '87020780@bos.polri.go.id', 'roles' => [5],  'password' => '87020780' ],
[  'nrp' =>'88040409', 'email' => '88040409@bos.polri.go.id', 'roles' => [5],  'password' => '88040409' ],
[  'nrp' =>'75010428', 'email' => '75010428@bos.polri.go.id', 'roles' => [5],  'password' => '75010428' ],
[  'nrp' =>'75040233', 'email' => '75040233@bos.polri.go.id', 'roles' => [5],  'password' => '75040233' ],
[  'nrp' =>'78080919', 'email' => '78080919@bos.polri.go.id', 'roles' => [5],  'password' => '78080919' ],
[  'nrp' =>'78120567', 'email' => '78120567@bos.polri.go.id', 'roles' => [5],  'password' => '78120567' ],
[  'nrp' =>'81010435', 'email' => '81010435@bos.polri.go.id', 'roles' => [5],  'password' => '81010435' ],
[  'nrp' =>'79081031', 'email' => '79081031@bos.polri.go.id', 'roles' => [5],  'password' => '79081031' ],
[  'nrp' =>'79060380', 'email' => '79060380@bos.polri.go.id', 'roles' => [5],  'password' => '79060380' ],
[  'nrp' =>'84120149', 'email' => '84120149@bos.polri.go.id', 'roles' => [5],  'password' => '84120149' ],
[  'nrp' =>'82061225', 'email' => '82061225@bos.polri.go.id', 'roles' => [5],  'password' => '82061225' ],
[  'nrp' =>'85021094', 'email' => '85021094@bos.polri.go.id', 'roles' => [5],  'password' => '85021094' ],
[  'nrp' =>'86041141', 'email' => '86041141@bos.polri.go.id', 'roles' => [5],  'password' => '86041141' ],
[  'nrp' =>'75100847', 'email' => '75100847@bos.polri.go.id', 'roles' => [5],  'password' => '75100847' ],
[  'nrp' =>'84070756', 'email' => '84070756@bos.polri.go.id', 'roles' => [5],  'password' => '84070756' ],
[  'nrp' =>'85050581', 'email' => '85050581@bos.polri.go.id', 'roles' => [5],  'password' => '85050581' ],
[  'nrp' =>'89080315', 'email' => '89080315@bos.polri.go.id', 'roles' => [5],  'password' => '89080315' ],
[  'nrp' =>'84070866', 'email' => '84070866@bos.polri.go.id', 'roles' => [5],  'password' => '84070866' ],
[  'nrp' =>'85051912', 'email' => '85051912@bos.polri.go.id', 'roles' => [5],  'password' => '85051912' ],
[  'nrp' =>'75010428', 'email' => '75010428@bos.polri.go.id', 'roles' => [5],  'password' => '75010428' ],
[  'nrp' =>'75040233', 'email' => '75040233@bos.polri.go.id', 'roles' => [5],  'password' => '75040233' ],
[  'nrp' =>'78080919', 'email' => '78080919@bos.polri.go.id', 'roles' => [5],  'password' => '78080919' ],
[  'nrp' =>'78120567', 'email' => '78120567@bos.polri.go.id', 'roles' => [5],  'password' => '78120567' ],
[  'nrp' =>'81010435', 'email' => '81010435@bos.polri.go.id', 'roles' => [5],  'password' => '81010435' ],
[  'nrp' =>'79081031', 'email' => '79081031@bos.polri.go.id', 'roles' => [5],  'password' => '79081031' ],
[  'nrp' =>'79060380', 'email' => '79060380@bos.polri.go.id', 'roles' => [5],  'password' => '79060380' ],
[  'nrp' =>'77070893', 'email' => '77070893@bos.polri.go.id', 'roles' => [5],  'password' => '77070893' ],
[  'nrp' =>'78060580', 'email' => '78060580@bos.polri.go.id', 'roles' => [5],  'password' => '78060580' ],
[  'nrp' =>'88010226', 'email' => '88010226@bos.polri.go.id', 'roles' => [5],  'password' => '88010226' ],
[  'nrp' =>'79020859', 'email' => '79020859@bos.polri.go.id', 'roles' => [5],  'password' => '79020859' ],
[  'nrp' =>'85101643', 'email' => '85101643@bos.polri.go.id', 'roles' => [5],  'password' => '85101643' ],
[  'nrp' =>'89060069', 'email' => '89060069@bos.polri.go.id', 'roles' => [5],  'password' => '89060069' ],
[  'nrp' =>'85060385', 'email' => '85060385@bos.polri.go.id', 'roles' => [5],  'password' => '85060385' ],
[  'nrp' =>'80091154', 'email' => '80091154@bos.polri.go.id', 'roles' => [5],  'password' => '80091154' ],
[  'nrp' =>'84121836', 'email' => '84121836@bos.polri.go.id', 'roles' => [5],  'password' => '84121836' ],
[  'nrp' =>'80011136', 'email' => '80011136@bos.polri.go.id', 'roles' => [5],  'password' => '80011136' ],
[  'nrp' =>'94110645', 'email' => '94110645@bos.polri.go.id', 'roles' => [5],  'password' => '94110645' ],
[  'nrp' =>'87081382', 'email' => '87081382@bos.polri.go.id', 'roles' => [5],  'password' => '87081382' ],
[  'nrp' =>'85010821', 'email' => '85010821@bos.polri.go.id', 'roles' => [5],  'password' => '85010821' ],
[  'nrp' =>'84121209', 'email' => '84121209@bos.polri.go.id', 'roles' => [5],  'password' => '84121209' ],
[  'nrp' =>'82110601', 'email' => '82110601@bos.polri.go.id', 'roles' => [5],  'password' => '82110601' ],
[  'nrp' =>'80070703', 'email' => '80070703@bos.polri.go.id', 'roles' => [5],  'password' => '80070703' ],
[  'nrp' =>'85010361', 'email' => '85010361@bos.polri.go.id', 'roles' => [5],  'password' => '85010361' ],
[  'nrp' =>'94100680', 'email' => '94100680@bos.polri.go.id', 'roles' => [5],  'password' => '94100680' ],
[  'nrp' =>'85120651', 'email' => '85120651@bos.polri.go.id', 'roles' => [5],  'password' => '85120651' ],
[  'nrp' =>'87010077', 'email' => '87010077@bos.polri.go.id', 'roles' => [5],  'password' => '87010077' ],
[  'nrp' =>'88040865', 'email' => '88040865@bos.polri.go.id', 'roles' => [5],  'password' => '88040865' ],
[  'nrp' =>'86090188', 'email' => '86090188@bos.polri.go.id', 'roles' => [5],  'password' => '86090188' ],
[  'nrp' =>'87030835', 'email' => '87030835@bos.polri.go.id', 'roles' => [5],  'password' => '87030835' ],
[  'nrp' =>'88070851', 'email' => '88070851@bos.polri.go.id', 'roles' => [5],  'password' => '88070851' ],
[  'nrp' =>'73120695', 'email' => '73120695@bos.polri.go.id', 'roles' => [5],  'password' => '73120695' ],
[  'nrp' =>'85061917', 'email' => '85061917@bos.polri.go.id', 'roles' => [5],  'password' => '85061917' ],
[  'nrp' =>'92090699', 'email' => '92090699@bos.polri.go.id', 'roles' => [5],  'password' => '92090699' ],
[  'nrp' =>'85121753', 'email' => '85121753@bos.polri.go.id', 'roles' => [5],  'password' => '85121753' ],
[  'nrp' =>'81110981', 'email' => '81110981@bos.polri.go.id', 'roles' => [5],  'password' => '81110981' ],
[  'nrp' =>'94080442', 'email' => '94080442@bos.polri.go.id', 'roles' => [5],  'password' => '94080442' ],
[  'nrp' =>'92110508', 'email' => '92110508@bos.polri.go.id', 'roles' => [5],  'password' => '92110508' ],
[  'nrp' =>'93070776', 'email' => '93070776@bos.polri.go.id', 'roles' => [5],  'password' => '93070776' ],
[  'nrp' =>'93020422', 'email' => '93020422@bos.polri.go.id', 'roles' => [5],  'password' => '93020422' ],
[  'nrp' =>'93110682', 'email' => '93110682@bos.polri.go.id', 'roles' => [5],  'password' => '93110682' ],
[  'nrp' =>'95020591', 'email' => '95020591@bos.polri.go.id', 'roles' => [5],  'password' => '95020591' ],
[  'nrp' =>'95060687', 'email' => '95060687@bos.polri.go.id', 'roles' => [5],  'password' => '95060687' ],
[  'nrp' =>'85010608', 'email' => '85010608@bos.polri.go.id', 'roles' => [5],  'password' => '85010608' ],
[  'nrp' =>'78120387', 'email' => '78120387@bos.polri.go.id', 'roles' => [5],  'password' => '78120387' ],
[  'nrp' =>'93080463', 'email' => '93080463@bos.polri.go.id', 'roles' => [5],  'password' => '93080463' ],
[  'nrp' =>'93090502', 'email' => '93090502@bos.polri.go.id', 'roles' => [5],  'password' => '93090502' ],
[  'nrp' =>'84010412', 'email' => '84010412@bos.polri.go.id', 'roles' => [5],  'password' => '84010412' ],
[  'nrp' =>'88090946', 'email' => '88090946@bos.polri.go.id', 'roles' => [5],  'password' => '88090946' ],
[  'nrp' =>'80030319', 'email' => '80030319@bos.polri.go.id', 'roles' => [5],  'password' => '80030319' ],
[  'nrp' =>'83101042', 'email' => '83101042@bos.polri.go.id', 'roles' => [5],  'password' => '83101042' ],
[  'nrp' =>'75120299', 'email' => '75120299@bos.polri.go.id', 'roles' => [5],  'password' => '75120299' ],
[  'nrp' =>'82110985', 'email' => '82110985@bos.polri.go.id', 'roles' => [5],  'password' => '82110985' ],
[  'nrp' =>'83050753', 'email' => '83050753@bos.polri.go.id', 'roles' => [5],  'password' => '83050753' ],
[  'nrp' =>'89050320', 'email' => '89050320@bos.polri.go.id', 'roles' => [5],  'password' => '89050320' ],
[  'nrp' =>'89050320', 'email' => '89050320@bos.polri.go.id', 'roles' => [5],  'password' => '89050320' ],
[  'nrp' =>'84031363', 'email' => '84031363@bos.polri.go.id', 'roles' => [5],  'password' => '84031363' ],
[  'nrp' =>'83091107', 'email' => '83091107@bos.polri.go.id', 'roles' => [5],  'password' => '83091107' ],
[  'nrp' =>'85070985', 'email' => '85070985@bos.polri.go.id', 'roles' => [5],  'password' => '85070985' ],
[  'nrp' =>'88060037', 'email' => '88060037@bos.polri.go.id', 'roles' => [5],  'password' => '88060037' ],
[  'nrp' =>'84061709', 'email' => '84061709@bos.polri.go.id', 'roles' => [5],  'password' => '84061709' ],
[  'nrp' =>'93031015', 'email' => '93031015@bos.polri.go.id', 'roles' => [5],  'password' => '93031015' ],
[  'nrp' =>'79070656', 'email' => '79070656@bos.polri.go.id', 'roles' => [5],  'password' => '79070656' ],
[  'nrp' =>'81070567', 'email' => '81070567@bos.polri.go.id', 'roles' => [5],  'password' => '81070567' ],
[  'nrp' =>'86080478', 'email' => '86080478@bos.polri.go.id', 'roles' => [5],  'password' => '86080478' ],
[  'nrp' =>'78081378', 'email' => '78081378@bos.polri.go.id', 'roles' => [5],  'password' => '78081378' ],
[  'nrp' =>'82041410', 'email' => '82041410@bos.polri.go.id', 'roles' => [5],  'password' => '82041410' ],
[  'nrp' =>'81100213', 'email' => '81100213@bos.polri.go.id', 'roles' => [5],  'password' => '81100213' ],
[  'nrp' =>'86080393', 'email' => '86080393@bos.polri.go.id', 'roles' => [5],  'password' => '86080393' ],
[  'nrp' =>'83120005', 'email' => '83120005@bos.polri.go.id', 'roles' => [5],  'password' => '83120005' ],
[  'nrp' =>'77110189', 'email' => '77110189@bos.polri.go.id', 'roles' => [5],  'password' => '77110189' ],
[  'nrp' =>'86060588', 'email' => '86060588@bos.polri.go.id', 'roles' => [5],  'password' => '86060588' ],
[  'nrp' =>'84020281', 'email' => '84020281@bos.polri.go.id', 'roles' => [5],  'password' => '84020281' ],
[  'nrp' =>'86040289', 'email' => '86040289@bos.polri.go.id', 'roles' => [5],  'password' => '86040289' ],
[  'nrp' =>'86031085', 'email' => '86031085@bos.polri.go.id', 'roles' => [5],  'password' => '86031085' ],
[  'nrp' =>'89060050', 'email' => '89060050@bos.polri.go.id', 'roles' => [5],  'password' => '89060050' ],
[  'nrp' =>'84051413', 'email' => '84051413@bos.polri.go.id', 'roles' => [5],  'password' => '84051413' ],
[  'nrp' =>'83040182', 'email' => '83040182@bos.polri.go.id', 'roles' => [5],  'password' => '83040182' ],
[  'nrp' =>'73070382', 'email' => '73070382@bos.polri.go.id', 'roles' => [5],  'password' => '73070382' ],
[  'nrp' =>'86040683', 'email' => '86040683@bos.polri.go.id', 'roles' => [5],  'password' => '86040683' ],
[  'nrp' =>'77110811', 'email' => '77110811@bos.polri.go.id', 'roles' => [5],  'password' => '77110811' ],
[  'nrp' =>'77071156', 'email' => '77071156@bos.polri.go.id', 'roles' => [5],  'password' => '77071156' ],
[  'nrp' =>'86051477', 'email' => '86051477@bos.polri.go.id', 'roles' => [5],  'password' => '86051477' ],
[  'nrp' =>'85010550', 'email' => '85010550@bos.polri.go.id', 'roles' => [5],  'password' => '85010550' ],
[  'nrp' =>'78030041', 'email' => '78030041@bos.polri.go.id', 'roles' => [5],  'password' => '78030041' ],
[  'nrp' =>'79100037', 'email' => '79100037@bos.polri.go.id', 'roles' => [5],  'password' => '79100037' ],
[  'nrp' =>'82010487', 'email' => '82010487@bos.polri.go.id', 'roles' => [5],  'password' => '82010487' ],
[  'nrp' =>'82030746', 'email' => '82030746@bos.polri.go.id', 'roles' => [5],  'password' => '82030746' ],
[  'nrp' =>'82020380', 'email' => '82020380@bos.polri.go.id', 'roles' => [5],  'password' => '82020380' ],
[  'nrp' =>'81050067', 'email' => '81050067@bos.polri.go.id', 'roles' => [5],  'password' => '81050067' ],
[  'nrp' =>'77081020', 'email' => '77081020@bos.polri.go.id', 'roles' => [5],  'password' => '77081020' ],
[  'nrp' =>'82070813', 'email' => '82070813@bos.polri.go.id', 'roles' => [5],  'password' => '82070813' ],
[  'nrp' =>'83091090', 'email' => '83091090@bos.polri.go.id', 'roles' => [5],  'password' => '83091090' ],
[  'nrp' =>'84071010', 'email' => '84071010@bos.polri.go.id', 'roles' => [5],  'password' => '84071010' ],
[  'nrp' =>'84071698', 'email' => '84071698@bos.polri.go.id', 'roles' => [5],  'password' => '84071698' ],
[  'nrp' =>'84121645', 'email' => '84121645@bos.polri.go.id', 'roles' => [5],  'password' => '84121645' ],
[  'nrp' =>'87040375', 'email' => '87040375@bos.polri.go.id', 'roles' => [5],  'password' => '87040375' ],
[  'nrp' =>'86031713', 'email' => '86031713@bos.polri.go.id', 'roles' => [5],  'password' => '86031713' ],
[  'nrp' =>'88120308', 'email' => '88120308@bos.polri.go.id', 'roles' => [5],  'password' => '88120308' ],
[  'nrp' =>'83101036', 'email' => '83101036@bos.polri.go.id', 'roles' => [5],  'password' => '83101036' ],
[  'nrp' =>'84060983', 'email' => '84060983@bos.polri.go.id', 'roles' => [5],  'password' => '84060983' ],
[  'nrp' =>'84090883', 'email' => '84090883@bos.polri.go.id', 'roles' => [5],  'password' => '84090883' ],
[  'nrp' =>'80081346', 'email' => '80081346@bos.polri.go.id', 'roles' => [5],  'password' => '80081346' ],
[  'nrp' =>'85041365', 'email' => '85041365@bos.polri.go.id', 'roles' => [5],  'password' => '85041365' ],
[  'nrp' =>'82121193', 'email' => '82121193@bos.polri.go.id', 'roles' => [5],  'password' => '82121193' ],
[  'nrp' =>'84040868', 'email' => '84040868@bos.polri.go.id', 'roles' => [5],  'password' => '84040868' ],
[  'nrp' =>'83120140', 'email' => '83120140@bos.polri.go.id', 'roles' => [5],  'password' => '83120140' ],
[  'nrp' =>'83101103', 'email' => '83101103@bos.polri.go.id', 'roles' => [5],  'password' => '83101103' ],
[  'nrp' =>'85051771', 'email' => '85051771@bos.polri.go.id', 'roles' => [5],  'password' => '85051771' ],
[  'nrp' =>'86101703', 'email' => '86101703@bos.polri.go.id', 'roles' => [5],  'password' => '86101703' ],
[  'nrp' =>'79110200', 'email' => '79110200@bos.polri.go.id', 'roles' => [5],  'password' => '79110200' ],
[  'nrp' =>'76090110', 'email' => '76090110@bos.polri.go.id', 'roles' => [5],  'password' => '76090110' ],
[  'nrp' =>'84040280', 'email' => '84040280@bos.polri.go.id', 'roles' => [5],  'password' => '84040280' ],
[  'nrp' =>'81111135', 'email' => '81111135@bos.polri.go.id', 'roles' => [5],  'password' => '81111135' ],
[  'nrp' =>'78010541', 'email' => '78010541@bos.polri.go.id', 'roles' => [5],  'password' => '78010541' ],
[  'nrp' =>'83120807', 'email' => '83120807@bos.polri.go.id', 'roles' => [5],  'password' => '83120807' ],
[  'nrp' =>'84081540', 'email' => '84081540@bos.polri.go.id', 'roles' => [5],  'password' => '84081540' ],
[  'nrp' =>'88010526', 'email' => '88010526@bos.polri.go.id', 'roles' => [5],  'password' => '88010526' ],
[  'nrp' =>'87071645', 'email' => '87071645@bos.polri.go.id', 'roles' => [5],  'password' => '87071645' ],
[  'nrp' =>'87080095', 'email' => '87080095@bos.polri.go.id', 'roles' => [5],  'password' => '87080095' ],
[  'nrp' =>'88070225', 'email' => '88070225@bos.polri.go.id', 'roles' => [5],  'password' => '88070225' ],
[  'nrp' =>'88040331', 'email' => '88040331@bos.polri.go.id', 'roles' => [5],  'password' => '88040331' ],
[  'nrp' =>'86101471', 'email' => '86101471@bos.polri.go.id', 'roles' => [5],  'password' => '86101471' ],
[  'nrp' =>'84090750', 'email' => '84090750@bos.polri.go.id', 'roles' => [5],  'password' => '84090750' ],
[  'nrp' =>'88031107', 'email' => '88031107@bos.polri.go.id', 'roles' => [5],  'password' => '88031107' ],
[  'nrp' =>'86041764', 'email' => '86041764@bos.polri.go.id', 'roles' => [5],  'password' => '86041764' ],
[  'nrp' =>'72040424', 'email' => '72040424@bos.polri.go.id', 'roles' => [5],  'password' => '72040424' ],
[  'nrp' =>'81100939', 'email' => '81100939@bos.polri.go.id', 'roles' => [5],  'password' => '81100939' ],
[  'nrp' =>'81111030', 'email' => '81111030@bos.polri.go.id', 'roles' => [5],  'password' => '81111030' ],
[  'nrp' =>'78031060', 'email' => '78031060@bos.polri.go.id', 'roles' => [5],  'password' => '78031060' ],
[  'nrp' =>'79020644', 'email' => '79020644@bos.polri.go.id', 'roles' => [5],  'password' => '79020644' ],
[  'nrp' =>'76090193', 'email' => '76090193@bos.polri.go.id', 'roles' => [5],  'password' => '76090193' ],
[  'nrp' =>'79100932', 'email' => '79100932@bos.polri.go.id', 'roles' => [5],  'password' => '79100932' ],
[  'nrp' =>'82040945', 'email' => '82040945@bos.polri.go.id', 'roles' => [5],  'password' => '82040945' ],
[  'nrp' =>'83101339', 'email' => '83101339@bos.polri.go.id', 'roles' => [5],  'password' => '83101339' ],
[  'nrp' =>'87031168', 'email' => '87031168@bos.polri.go.id', 'roles' => [5],  'password' => '87031168' ],
[  'nrp' =>'80090891', 'email' => '80090891@bos.polri.go.id', 'roles' => [5],  'password' => '80090891' ],
[  'nrp' =>'81030840', 'email' => '81030840@bos.polri.go.id', 'roles' => [5],  'password' => '81030840' ],
[  'nrp' =>'84071362', 'email' => '84071362@bos.polri.go.id', 'roles' => [5],  'password' => '84071362' ],
[  'nrp' =>'88030203', 'email' => '88030203@bos.polri.go.id', 'roles' => [5],  'password' => '88030203' ],
[  'nrp' =>'75050587', 'email' => '75050587@bos.polri.go.id', 'roles' => [5],  'password' => '75050587' ],
[  'nrp' =>'88120556', 'email' => '88120556@bos.polri.go.id', 'roles' => [5],  'password' => '88120556' ],
[  'nrp' =>'88010700', 'email' => '88010700@bos.polri.go.id', 'roles' => [5],  'password' => '88010700' ],
[  'nrp' =>'88050984', 'email' => '88050984@bos.polri.go.id', 'roles' => [5],  'password' => '88050984' ],
[  'nrp' =>'81121001', 'email' => '81121001@bos.polri.go.id', 'roles' => [5],  'password' => '81121001' ],
[  'nrp' =>'77050875', 'email' => '77050875@bos.polri.go.id', 'roles' => [5],  'password' => '77050875' ],
[  'nrp' =>'95050668', 'email' => '95050668@bos.polri.go.id', 'roles' => [5],  'password' => '95050668' ],
[  'nrp' =>'93090049', 'email' => '93090049@bos.polri.go.id', 'roles' => [5],  'password' => '93090049' ],
[  'nrp' =>'63060676', 'email' => '63060676@bos.polri.go.id', 'roles' => [5],  'password' => '63060676' ],
[  'nrp' =>'75080920', 'email' => '75080920@bos.polri.go.id', 'roles' => [5],  'password' => '75080920' ],
[  'nrp' =>'79081502', 'email' => '79081502@bos.polri.go.id', 'roles' => [5],  'password' => '79081502' ],
[  'nrp' =>'81100932', 'email' => '81100932@bos.polri.go.id', 'roles' => [5],  'password' => '81100932' ],
[  'nrp' =>'81091188', 'email' => '81091188@bos.polri.go.id', 'roles' => [5],  'password' => '81091188' ],
[  'nrp' =>'85031584', 'email' => '85031584@bos.polri.go.id', 'roles' => [5],  'password' => '85031584' ],
[  'nrp' =>'86090285', 'email' => '86090285@bos.polri.go.id', 'roles' => [5],  'password' => '86090285' ],
[  'nrp' =>'77070911', 'email' => '77070911@bos.polri.go.id', 'roles' => [5],  'password' => '77070911' ],
[  'nrp' =>'88080168', 'email' => '88080168@bos.polri.go.id', 'roles' => [5],  'password' => '88080168' ],
[  'nrp' =>'64120635', 'email' => '64120635@bos.polri.go.id', 'roles' => [5],  'password' => '64120635' ],
[  'nrp' =>'64110418', 'email' => '64110418@bos.polri.go.id', 'roles' => [5],  'password' => '64110418' ],
[  'nrp' =>'71120084', 'email' => '71120084@bos.polri.go.id', 'roles' => [5],  'password' => '71120084' ],
[  'nrp' =>'84020779', 'email' => '84020779@bos.polri.go.id', 'roles' => [5],  'password' => '84020779' ],
[  'nrp' =>'79011032', 'email' => '79011032@bos.polri.go.id', 'roles' => [5],  'password' => '79011032' ],
[  'nrp' =>'79061364', 'email' => '79061364@bos.polri.go.id', 'roles' => [5],  'password' => '79061364' ],
[  'nrp' =>'85060045', 'email' => '85060045@bos.polri.go.id', 'roles' => [5],  'password' => '85060045' ],
[  'nrp' =>'85011556', 'email' => '85011556@bos.polri.go.id', 'roles' => [5],  'password' => '85011556' ],
[  'nrp' =>'80030049', 'email' => '80030049@bos.polri.go.id', 'roles' => [5],  'password' => '80030049' ],
[  'nrp' =>'83031274', 'email' => '83031274@bos.polri.go.id', 'roles' => [5],  'password' => '83031274' ],
[  'nrp' =>'82121125', 'email' => '82121125@bos.polri.go.id', 'roles' => [5],  'password' => '82121125' ],
[  'nrp' =>'86020606', 'email' => '86020606@bos.polri.go.id', 'roles' => [5],  'password' => '86020606' ],
[  'nrp' =>'86041779', 'email' => '86041779@bos.polri.go.id', 'roles' => [5],  'password' => '86041779' ],
[  'nrp' =>'83120525', 'email' => '83120525@bos.polri.go.id', 'roles' => [5],  'password' => '83120525' ],
[  'nrp' =>'85100167', 'email' => '85100167@bos.polri.go.id', 'roles' => [5],  'password' => '85100167' ],
[  'nrp' =>'83041040', 'email' => '83041040@bos.polri.go.id', 'roles' => [5],  'password' => '83041040' ],
[  'nrp' =>'86061879', 'email' => '86061879@bos.polri.go.id', 'roles' => [5],  'password' => '86061879' ],
[  'nrp' =>'87070857', 'email' => '87070857@bos.polri.go.id', 'roles' => [5],  'password' => '87070857' ],
[  'nrp' =>'74060235', 'email' => '74060235@bos.polri.go.id', 'roles' => [5],  'password' => '74060235' ],
[  'nrp' =>'81100464', 'email' => '81100464@bos.polri.go.id', 'roles' => [5],  'password' => '81100464' ],
[  'nrp' =>'74020470', 'email' => '74020470@bos.polri.go.id', 'roles' => [5],  'password' => '74020470' ],
[  'nrp' =>'85100623', 'email' => '85100623@bos.polri.go.id', 'roles' => [5],  'password' => '85100623' ],
[  'nrp' =>'76040581', 'email' => '76040581@bos.polri.go.id', 'roles' => [5],  'password' => '76040581' ],
[  'nrp' =>'87040468', 'email' => '87040468@bos.polri.go.id', 'roles' => [5],  'password' => '87040468' ],
[  'nrp' =>'86081877', 'email' => '86081877@bos.polri.go.id', 'roles' => [5],  'password' => '86081877' ],
[  'nrp' =>'76120343', 'email' => '76120343@bos.polri.go.id', 'roles' => [5],  'password' => '76120343' ],
[  'nrp' =>'87041341', 'email' => '87041341@bos.polri.go.id', 'roles' => [5],  'password' => '87041341' ],
[  'nrp' =>'65010048', 'email' => '65010048@bos.polri.go.id', 'roles' => [5],  'password' => '65010048' ],
[  'nrp' =>'65080505', 'email' => '65080505@bos.polri.go.id', 'roles' => [5],  'password' => '65080505' ],
[  'nrp' =>'75070522', 'email' => '75070522@bos.polri.go.id', 'roles' => [5],  'password' => '75070522' ],
[  'nrp' =>'66050560', 'email' => '66050560@bos.polri.go.id', 'roles' => [5],  'password' => '66050560' ],
[  'nrp' =>'85050364', 'email' => '85050364@bos.polri.go.id', 'roles' => [5],  'password' => '85050364' ],
[  'nrp' =>'84081495', 'email' => '84081495@bos.polri.go.id', 'roles' => [5],  'password' => '84081495' ],
[  'nrp' =>'81080811', 'email' => '81080811@bos.polri.go.id', 'roles' => [5],  'password' => '81080811' ],
[  'nrp' =>'65080505', 'email' => '65080505@bos.polri.go.id', 'roles' => [5],  'password' => '65080505' ],
[  'nrp' =>'87070606', 'email' => '87070606@bos.polri.go.id', 'roles' => [5],  'password' => '87070606' ],
[  'nrp' =>'76070233', 'email' => '76070233@bos.polri.go.id', 'roles' => [5],  'password' => '76070233' ],
[  'nrp' =>'82121125', 'email' => '82121125@bos.polri.go.id', 'roles' => [5],  'password' => '82121125' ],
[  'nrp' =>'86020606', 'email' => '86020606@bos.polri.go.id', 'roles' => [5],  'password' => '86020606' ],
[  'nrp' =>'86041779', 'email' => '86041779@bos.polri.go.id', 'roles' => [5],  'password' => '86041779' ],
[  'nrp' =>'83120525', 'email' => '83120525@bos.polri.go.id', 'roles' => [5],  'password' => '83120525' ],
[  'nrp' =>'85100167', 'email' => '85100167@bos.polri.go.id', 'roles' => [5],  'password' => '85100167' ],
[  'nrp' =>'83041040', 'email' => '83041040@bos.polri.go.id', 'roles' => [5],  'password' => '83041040' ],
[  'nrp' =>'80110710', 'email' => '80110710@bos.polri.go.id', 'roles' => [5],  'password' => '80110710' ],
[  'nrp' =>'83030802', 'email' => '83030802@bos.polri.go.id', 'roles' => [5],  'password' => '83030802' ],
[  'nrp' =>'83050752', 'email' => '83050752@bos.polri.go.id', 'roles' => [5],  'password' => '83050752' ],
[  'nrp' =>'96060733', 'email' => '96060733@bos.polri.go.id', 'roles' => [5],  'password' => '96060733' ],
[  'nrp' =>'79090254', 'email' => '79090254@bos.polri.go.id', 'roles' => [5],  'password' => '79090254' ],
[  'nrp' =>'85051559', 'email' => '85051559@bos.polri.go.id', 'roles' => [5],  'password' => '85051559' ],
[  'nrp' =>'88120120', 'email' => '88120120@bos.polri.go.id', 'roles' => [5],  'password' => '88120120' ],
[  'nrp' =>'87040837', 'email' => '87040837@bos.polri.go.id', 'roles' => [5],  'password' => '87040837' ],
[  'nrp' =>'80101174', 'email' => '80101174@bos.polri.go.id', 'roles' => [5],  'password' => '80101174' ],
[  'nrp' =>'76080865', 'email' => '76080865@bos.polri.go.id', 'roles' => [5],  'password' => '76080865' ],
[  'nrp' =>'80120015', 'email' => '80120015@bos.polri.go.id', 'roles' => [5],  'password' => '80120015' ],
[  'nrp' =>'92110808', 'email' => '92110808@bos.polri.go.id', 'roles' => [5],  'password' => '92110808' ],
[  'nrp' =>'86111162', 'email' => '86111162@bos.polri.go.id', 'roles' => [5],  'password' => '86111162' ],
[  'nrp' =>'86091602', 'email' => '86091602@bos.polri.go.id', 'roles' => [5],  'password' => '86091602' ],
[  'nrp' =>'80120753', 'email' => '80120753@bos.polri.go.id', 'roles' => [5],  'password' => '80120753' ],
[  'nrp' =>'81070538', 'email' => '81070538@bos.polri.go.id', 'roles' => [5],  'password' => '81070538' ],
[  'nrp' =>'64070107', 'email' => '64070107@bos.polri.go.id', 'roles' => [5],  'password' => '64070107' ],

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