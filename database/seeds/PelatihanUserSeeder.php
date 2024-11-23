<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class PelatihanUserSeeder extends Seeder
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
            [  
                'nrp' =>'70120667', 
                'email' => 'ruslan@bospolri.com', 
                'roles' => [5],  
                'password' => '70120667' 
            ],
            [  
                'nrp' =>'76010519', 
                'email' => 'NUAR0132@GMAIL.COM', 
                'roles' => [5],  
                'password' => '76010519' 
            ],
            [  
                'nrp' =>'93110726', 
                'email' => 'ARIFMUHAMMAD.KSP@GMAIL.COM', 
                'roles' => [5],  
                'password' => '93110726' 
            ],
            [  
                'nrp' =>'64040999', 
                'email' => 'BUDIMANBIDKUMPOLDASUMUT@GMAIL.COM', 
                'roles' => [5],  
                'password' => '64040999' 
            ],
            [  
                'nrp' =>'95040790', 
                'email' => 'CHERDIKAA@YAHOO.COM', 
                'roles' => [5],  
                'password' => '95040790' 
            ],
            [  
                'nrp' =>'95040929', 
                'email' => 'isirenaja@gmail.com', 
                'roles' => [5],  
                'password' => '95040929' 
            ],
            [  
                'nrp' =>'82041131', 
                'email' => 'UPANK03@YAHOO.COM', 
                'roles' => [5],  
                'password' => '82041131' 
            ],
            [  
                'nrp' =>'84081233',
                 'email' => 'perta@bospolri.com', 
                 'roles' => [5],  
                 'password' => '84081233' 
                ],
            [  
                'nrp' =>'78050479', 
                'email' => 'SURYADARMASH@GMIAL.COM', 
                'roles' => [5],  
                'password' => '78050479' 
            ],
            [  
                'nrp' =>'75090793', 
                'email' => 'SIGIT_JEEP@YAHOO.CO.ID', 
                'roles' => [5],  
                'password' => '75090793' 
            ],
            [  
                'nrp' =>'73110621', 
                'email' => 'JAYABAKTI1441@GMAIL.COM', 
                'roles' => [5],  
                'password' => '73110621' 
            ],
            [  
                'nrp' =>'87031563', 
                'email' => 'PERDIJALNI7@GMAIL.COM', 
                'roles' => [5],  
                'password' => '87031563' 
            ],
            [  
                'nrp' =>'72040538', 
                'email' => 'AFRIYANIYANI61@YAHOO.COM', 
                'roles' => [5],  
                'password' => '72040538' 
            ],
            [  
                'nrp' =>'86091152', 
                'email' => 'AZRIMULYADI86@GMAIL.COM', 
                'roles' => [5],  
                'password' => '86091152' 
            ],
            [  
                'nrp' =>'91080229', 
                'email' => 'HARLANSASMITA91@GMAIL.COM', 
                'roles' => [5],  
                'password' => '91080229' 
            ],
            [  
                'nrp' =>'72080771', 
                'email' => 'KHOLILMUSTAFA17@GMAIL.COM', 
                'roles' => [5],  
                'password' => '72080771' 
            ],
            [  
                'nrp' =>'90100242', 
                'email' => 'NOVRIANSYAH72@GMAIL.COM', 
                'roles' => [5],  
                'password' => '90100242' 
            ],
            [  
                'nrp' =>'94020356', 
                'email' => 'Febidwiprayudha@gmail.com', 
                'roles' => [5],  
                'password' => '94020356' 
            ],
            [  
                'nrp' =>'65050305', 
                'email' => 'hadi@bospolri.com', 
                'roles' => [5],  
                'password' => '65050305' 
            ],
            [  
                'nrp' =>'82110087', 
                'email' => 'ENDRAWICAKSONO66@GMAIL.COM', 
                'roles' => [5],  
                'password' => '82110087' 
            ],
            [  
                'nrp' =>'97040647', 
                'email' => 'BAGUSSETYADI74@GMAIL.COM', 
                'roles' => [5],  
                'password' => '97040647' 
            ],
            [  
                'nrp' =>'71030350', 
                'email' => 'SKPT.SUMSEL@YAHOO.COM', 
                'roles' => [5],  
                'password' => '71030350' 
            ],
            [  
                'nrp' =>'84070618', 
                'email' => 'FADILAHFAJAR654@GMAIL.COM', 
                'roles' => [5],  
                'password' => '84070618' 
            ],
            [  
                'nrp' =>'85051904', 
                'email' => 'DOKTERVIVIN@GMAIL.COM', 
                'roles' => [5],  
                'password' => '85051904' 
            ],
            [  
                'nrp' =>'63110143', 
                'email' => 'HERNI.SISWATI1963@GMAIL.COM', 
                'roles' => [5],  
                'password' => '63110143' 
            ],
            [  
                'nrp' =>'88100079', 
                'email' => 'DUOBRIGADIR86@GMAIL.COM', 
                'roles' => [5],  
                'password' => '88100079' 
            ],
            [  
                'nrp' =>'96080705', 
                'email' => 'HASBIH950@GMAIL.COM', 
                'roles' => [5],  
                'password' => '96080705' 
            ],
            [  
                'nrp' =>'64100403', 
                'email' => 'www.ditnarkobalampung@ymail.com', 
                'roles' => [5],  
                'password' => '64100403' 
            ],
            [  
                'nrp' =>'86110303', 
                'email' => 'RAHMAD_NOVIYADI@YAHOO.CO.ID', 
                'roles' => [5],  
                'password' => '86110303' 
            ],
            [  
                'nrp' =>'87040933', 
                'email' => 'BENIOGASKA87@GMAIL.COM', 
                'roles' => [5],  
                'password' => '87040933' 
            ],
            [  
                'nrp' =>'71060491', 
                'email' => 'ANDARYOSO@POLRI.GO.ID', 
                'roles' => [5],  
                'password' => '71060491' 
            ],
            [  
                'nrp' =>'96070500', 
                'email' => 'wangsa@bospolri.com', 
                'roles' => [5],  
                'password' => '96070500' 
            ],
            [  
                'nrp' =>'94030234', 
                'email' => 'SULISTIYADIGINDRA@GAMIL.COM', 
                'roles' => [5],  
                'password' => '94030234' 
            ],
            [  
                'nrp' =>'74040764', 
                'email' => 'selipudjawijaya.se@gmail.com', 
                'roles' => [5],  
                'password' => '74040764' 
            ],
            [  
                'nrp' =>'80071428', 
                'email' => 'nurwanbowo@yahoo.co.id', 
                'roles' => [5],  
                'password' => '80071428' 
            ],
            [  
                'nrp' =>'90030145', 
                'email' => 'ELKA_NIRYAWAN@YAHOO.COM', 
                'roles' => [5],  
                'password' => '90030145' 
            ],
            [  
                'nrp' =>'64060873', 
                'email' => 'NETHSKADIVET@YMAIL.COM', 
                'roles' => [5],  
                'password' => '64060873' 
            ],
            [  
                'nrp' =>'78120356', 
                'email' => 'NATAKUSUMAH2898@GMAIL.COM', 
                'roles' => [5],  
                'password' => '78120356' 
            ],
            [  
                'nrp' =>'97070331', 
                'email' => 'MPRATAMAJUANDA40@GMAIL.COM', 
                'roles' => [5],  
                'password' => '97070331' 
            ],
            [  
                'nrp' =>'68100544', 
                'email' => 'YOEDHI9697@GMAIL.COM', 
                'roles' => [5],  
                'password' => '68100544' 
            ],
            [  
                'nrp' =>'67070050', 
                'email' => 'YTRISNANTO@GMAIL.COM', 
                'roles' => [5],  
                'password' => '67070050' 
            ],
            [  
                'nrp' =>'78020505', 
                'email' => 'CATUR@YAHOO.COM', 
                'roles' => [5],  
                'password' => '78020505' 
            ],
            [  
                'nrp' =>'65120055', 
                'email' => 'SRIKANDIYOGYA@YAHOO.CO.ID', 
                'roles' => [5],  
                'password' => '65120055' 
            ],
            [  
                'nrp' =>'81021083', 
                'email' => 'TONI.PURWANTO81@GMAIL.COM', 
                'roles' => [5],  
                'password' => '81021083' 
            ],
            [  
                'nrp' =>'94081113', 
                'email' => 'ANGGADWIP@GMAIL.COM', 
                'roles' => [5],  
                'password' => '94081113' 
            ],
            [  
                'nrp' =>'64110233', 
                'email' => 'MFATONI1965@GMAIL.COM', 
                'roles' => [5],  
                'password' => '64110233' 
            ],
            [  
                'nrp' =>'74080164', 
                'email' => 'N4Y427@GMAIL.COM', 
                'roles' => [5],  
                'password' => '74080164' 
            ],
            [  
                'nrp' =>'84091046', 
                'email' => 'FEBRI_AKHMAD@YAHOO.CO.ID', 
                'roles' => [5],  
                'password' => '84091046' 
            ],
            [  
                'nrp' =>'63070158', 
                'email' => 'KETUTDWIKORA@GMAIL.COM', 
                'roles' => [5],  
                'password' => '63070158' 
            ],
            [  
                'nrp' =>'95110201', 
                'email' => 'NOVENDIBUDI@GMAIL.COM', 
                'roles' => [5],  
                'password' => '95110201' 
            ],
            [  
                'nrp' =>'98010214', 
                'email' => 'NARENDRA.WIBAWA98@YAHOO.CO.ID', 
                'roles' => [5],  
                'password' => '98010214' 
            ],
            [  
                'nrp' =>'65050432', 
                'email' => 'koilmo@bospolri.com', 
                'roles' => [5],  
                'password' => '65050432' 
            ],
            [  
                'nrp' =>'91090184', 
                'email' => 'bobbybeding4@gmail.com', 
                'roles' => [5],  
                'password' => '91090184' 
            ],
            [  
                'nrp' =>'90080287', 
                'email' => 'rickyballi54@gmail.com', 
                'roles' => [5],  
                'password' => '90080287' 
            ],
            [  
                'nrp' =>'67030631', 
                'email' => 'DICKY_ADITYA80@YAHOO.COM', 
                'roles' => [5],  
                'password' => '67030631' 
            ],
            [  
                'nrp' =>'89010362', 
                'email' => 'andikhuwailid32@gmail.com', 
                'roles' => [5],  
                'password' => '89010362' 
            ],
            [  
                'nrp' =>'92020339', 
                'email' => 'ROBERT.MONTOLALU27@GMAIL.COM', 
                'roles' => [5],  
                'password' => '92020339' 
            ],
            [  
                'nrp' =>'76061058', 
                'email' => 'AYUNKUSWANAJI2@GMAIL.COM', 
                'roles' => [5],  
                'password' => '76061058' 
            ],
            [  
                'nrp' =>'78050862', 
                'email' => 'GEALGEOLDOANK@GMAIL.COM', 
                'roles' => [5],  
                'password' => '78050862' 
            ],
            [  
                'nrp' =>'84050635', 
                'email' => 'MARJUTYA@GMAIL.COM', 
                'roles' => [5],  
                'password' => '84050635' 
            ],
            [  
                'nrp' =>'71110439', 
                'email' => 'RIAN_TOHARI98@YAHOO.COM', 
                'roles' => [5],  
                'password' => '71110439' 
            ],
            [  
                'nrp' =>'71110366', 
                'email' => 'AKHMAD.SAID71@GMAIL.COM', 
                'roles' => [5],  
                'password' => '71110366' 
            ],
            [  
                'nrp' =>'98080863', 
                'email' => 'SULTAN.HD25@GMAIL.COM', 
                'roles' => [5],  
                'password' => '98080863' 
            ],
            [  
                'nrp' =>'73010698', 
                'email' => 'HARISSUPRIYADI.SH.MH@GMAIL.COM', 
                'roles' => [5],  
                'password' => '73010698' 
            ],
            [  
                'nrp' =>'73050654', 
                'email' => 'AANDAMRAH@YAHOO.COM', 
                'roles' => [5],  
                'password' => '73050654' 
            ],
            [  
                'nrp' =>'86071158', 
                'email' => 'EKARUSMITAAGUSTINA@GMAIL.COM', 
                'roles' => [5],  
                'password' => '86071158' 
            ],
            [  
                'nrp' =>'64080135', 
                'email' => 'syaifodin@bospolri.com', 
                'roles' => [5],  
                'password' => '64080135' 
            ],
            [  
                'nrp' =>'87080932', 
                'email' => 'LEONARD231507@GMAIL.COM', 
                'roles' => [5],  
                'password' => '87080932' 
            ],
            [  
                'nrp' =>'85090532', 
                'email' => 'SUTOPOWIJAYA28@GMAIL.COM', 
                'roles' => [5],  
                'password' => '85090532' 
            ],
            [  
                'nrp' =>'73050577', 
                'email' => 'abdulkr1234@gmail.com', 
                'roles' => [5],  
                'password' => '73050577' 
            ],
            [  
                'nrp' =>'94100657', 
                'email' => 'ERICKPUTRAGIRISETIAWAN@GMAIL.COM', 
                'roles' => [5],  
                'password' => '94100657' 
            ],
            [  
                'nrp' =>'96010498', 
                'email' => 'BAGUSAJA986@GMAIL.COM', 
                'roles' => [5],  
                'password' => '96010498' 
            ],
            [  
                'nrp' =>'70060461', 
                'email' => 'HARISWELONG97@GMAIL.COM', 
                'roles' => [5],  
                'password' => '70060461' 
            ],
            [  
                'nrp' =>'86041699', 
                'email' => 'huliselanreimo@gmail.com', 
                'roles' => [5],  
                'password' => '86041699' 
            ],
            [  
                'nrp' =>'88070758', 
                'email' => 'AKKALLND88@GMAIL.COM', 
                'roles' => [5],  
                'password' => '88070758' 
            ],
            [  
                'nrp' =>'75020251', 
                'email' => 'MUH.IKHSAN1434@GMAIL.COM', 
                'roles' => [5],  
                'password' => '75020251' 
            ],
            [  
                'nrp' =>'84060145', 
                'email' => 'firdaus@bospolri.com', 
                'roles' => [5],  
                'password' => '84060145' 
            ],
            [  
                'nrp' =>'99110158', 
                'email' => 'richardo@bospolri.com', 
                'roles' => [5],  
                'password' => '99110158' 
            ],
            [  
                'nrp' =>'72050513', 
                'email' => 'SPNLABUAN.SULTENG@GMAIL.COM', 
                'roles' => [5],  
                'password' => '72050513' 
            ],
            [  
                'nrp' =>'84120225', 
                'email' => 'afandi@bospolri.com', 
                'roles' => [5],  
                'password' => '84120225' 
            ],
            [  
                'nrp' =>'83020804', 
                'email' => 'SATPAMPOLSUSPOLDASULTENG@GMAIL.COM', 
                'roles' => [5],  
                'password' => '83020804' 
            ],
            [  
                'nrp' =>'64120113', 
                'email' => 'SUTOPODJOJOSUMARTO@.GMAIL.GO.ID', 
                'roles' => [5],  
                'password' => '64120113' 
            ],
            [  
                'nrp' =>'86011766', 
                'email' => 'FARHANKUDU@GMAIL.COM', 
                'roles' => [5],  
                'password' => '86011766' 
            ],
            [  
                'nrp' =>'01100060', 
                'email' => 'samiun@bospolri.com', 
                'roles' => [5],  
                'password' => '01100060' 
            ],
            [  
                'nrp' =>'63120165', 
                'email' => 'lumenta@bospolri.com', 
                'roles' => [5],  
                'password' => '63120165' 
            ],
            [  
                'nrp' =>'88041112', 
                'email' => 'MASWARNUR.68@GMAIL.COM', 
                'roles' => [5],  
                'password' => '88041112' 
            ],
            [  
                'nrp' =>'96080360', 
                'email' => 'ARIATIDIAMANIS43@GMAIL.COM', 
                'roles' => [5],  
                'password' => '96080360' 
            ],
            [  
                'nrp' =>'74010690', 
                'email' => 'YUSUFMARS@GMAIL.COM', 
                'roles' => [5],  
                'password' => '74010690' 
            ],
            [  
                'nrp' =>'81041289', 
                'email' => 'ADHARKENDARI2016@GMAIL.COM', 
                'roles' => [5],  
                'password' => '81041289' 
            ],
            [  
                'nrp' =>'99100536', 
                'email' => 'yusrilashari01@gmail.com', 
                'roles' => [5],  
                'password' => '99100536' 
            ],
            [  
                'nrp' =>'67100045', 
                'email' => 'BINMAS.POLDAMALUKU@GMAIL.COM', 
                'roles' => [5],  
                'password' => '67100045' 
            ],
            [  
                'nrp' =>'82090904', 
                'email' => 'binmas.poldamaluku@gmail.com', 
                'roles' => [5],  
                'password' => '82090904' 
            ],
            [  
                'nrp' =>'87070510', 
                'email' => 'ACHULUSTOM@GMAIL.COM', 
                'roles' => [5],  
                'password' => '87070510' 
            ],
            [  
                'nrp' =>'66010297', 
                'email' => 'imrans@gmail.com', 
                'roles' => [5],  
                'password' => '66010297' 
            ],
            [  
                'nrp' =>'84110762', 
                'email' => 'JUNET2004@GMAIL.COM', 
                'roles' => [5],  
                'password' => '84110762' 
            ],
            [  
                'nrp' =>'93030025', 
                'email' => 'DANNYCAMZTERZ.DC@GMAIL.COM', 
                'roles' => [5],  
                'password' => '93030025' 
            ],
            [  
                'nrp' =>'64050341', 
                'email' => 'resal@bospolri.com', 
                'roles' => [5],  
                'password' => '64050341' 
            ],
            [  
                'nrp' =>'97020265', 
                'email' => 'benmaditbinmaspoldapb@gmail.com', 
                'roles' => [5],  
                'password' => '97020265' 
            ],
            [  
                'nrp' =>'97080583', 
                'email' => 'firman@bospolri.com', 
                'roles' => [5],  
                'password' => '97080583' 
            ],
            [  
                'nrp' =>'65090398', 
                'email' => 'kaharudin@bospolri.com', 
                'roles' => [5],  
                'password' => '65090398' 
            ],
            [  
                'nrp' =>'80120687', 
                'email' => 'HERDY.IBRAHIM@YAHOO.COM', 
                'roles' => [5],  
                'password' => '80120687' 
            ],
            [  
                'nrp' =>'91110163', 
                'email' => 'makabori33@gmail.com', 
                'roles' => [5],  
                'password' => '91110163' 
            ],
            [  
                'nrp' =>'96061067', 
                'email' => 'DARMASP41@GMAIL.COM', 
                'roles' => [5],  
                'password' => '96061067' 
            ],
            [  
                'nrp' =>'97080564', 
                'email' => 'ariardana42@gmail.com', 
                'roles' => [5],  
                'password' => '97080564' 
            ],
            [  
                'nrp' =>'98060195', 
                'email' => 'ADISANJAYA385@GMAIL.COM', 
                'roles' => [5],  
                'password' => '98060195' 
            ],
            [  
                'nrp' =>'99110367', 
                'email' => 'muhammadelmaliki.99@gmail.com', 
                'roles' => [5],  
                'password' => '99110367' 
            ],
            [  
                'nrp' =>'99070711', 
                'email' => 'teukurafkiabetsya@gmail.com', 
                'roles' => [5],  
                'password' => '99070711' 
            ],
            [  
                'nrp' =>'66120586', 
                'email' => 'HADISISWO101@GMAIL.COM', 
                'roles' => [5],  
                'password' => '66120586' 
            ],
            [  
                'nrp' =>'94100646', 
                'email' => 'MUKSINGOMBEL@YAHOO.CO.ID', 
                'roles' => [5],  
                'password' => '94100646' 
            ],
            [  
                'nrp' =>'82040616', 
                'email' => 'irvan@bospolri.com', 
                'roles' => [5],  
                'password' => '82040616' 
            ],
            [  
                'nrp' =>'87011349', 
                'email' => 'faisal@bospolri.com', 
                'roles' => [5],  
                'password' => '87011349' 
            ],
            [  
                'nrp' =>'82110961', 
                'email' => 'BOYKESIMARMATA@GMAIL.COM', 
                'roles' => [5],  
                'password' => '82110961' 
            ],
            [  
                'nrp' =>'83090977', 
                'email' => 'HASANUDINWAHYUDI13@GMAIL.COM', 
                'roles' => [5],  
                'password' => '83090977' 
            ],
            [  
                'nrp' =>'77060263', 
                'email' => 'AGUSMERUYA1717@YAHOO.COM', 
                'roles' => [5],  
                'password' => '77060263' 
            ],
            [  
                'nrp' =>'83010806', 
                'email' => 'ARISPOSPOL@GMAIL.COM', 
                'roles' => [5],  
                'password' => '83010806' 
            ],
            [  
                'nrp' =>'80071304', 
                'email' => 'TAMAMLDT@GMAIL.COM', 
                'roles' => [5],  
                'password' => '80071304' 
            ],
            [  
                'nrp' =>'83120871', 
                'email' => 'TEGUHWI77@GMAIL.COM', 
                'roles' => [5],  
                'password' => '83120871' 
            ],
            [  
                'nrp' =>'75020161', 
                'email' => 'muin@bospolri.com', 
                'roles' => [5],  
                'password' => '75020161' 
            ],
            [  
                'nrp' =>'77070427', 
                'email' => 'sigit@bospolri.com', 
                'roles' => [5],  
                'password' => '77070427' 
            ],
            [  
                'nrp' =>'75030237', 
                'email' => 'SRIYONO12352@GMAIL.COM', 
                'roles' => [5],  
                'password' => '75030237' 
            ],
            [  
                'nrp' =>'79100331', 
                'email' => 'MURYANTO.HM@GMAIL.COM', 
                'roles' => [5],  
                'password' => '79100331' 
            ],
            [  
                'nrp' =>'84020111', 
                'email' => 'FEBRIOK1984@GMAIL.COM', 
                'roles' => [5],  
                'password' => '84020111' 
            ],
            [  
                'nrp' =>'77100624', 
                'email' => 'wahyono@bospolri.com', 
                'roles' => [5],  
                'password' => '77100624' 
            ],
            [  
                'nrp' =>'84070345', 
                'email' => 'AGUNGMF_84@YAHOO.COM', 
                'roles' => [5],  
                'password' => '84070345' 
            ],
            [  
                'nrp' =>'86020087', 
                'email' => 'RESKYJUWITA@GMAIL.COM', 
                'roles' => [5],  
                'password' => '86020087' 
            ],
            [  
                'nrp' =>'78120290', 
                'email' => 'kuzairi@bospolri.com', 
                'roles' => [5],  
                'password' => '78120290' 
            ],
            [  
                'nrp' =>'83010091', 
                'email' => 'ALFATIHQUA@GMAIL.COM', 
                'roles' => [5],  
                'password' => '83010091' 
            ],
            [  
                'nrp' =>'77100501', 
                'email' => 'TRIYONO88YAHOO@GMAIL.COM', 
                'roles' => [5],  
                'password' => '77100501' 
            ],
            [  
                'nrp' =>'82081069', 
                'email' => 'BHABIN.BANTARJAYA@GMAIL.COM', 
                'roles' => [5],  
                'password' => '82081069' 
            ],
            [  
                'nrp' =>'84021375', 
                'email' => 'RENDRAANGGA@GMAIL.COM', 
                'roles' => [5],  
                'password' => '84021375' 
            ],
            [  
                'nrp' =>'87081064', 
                'email' => 'ADEHARYONO999@GMAIL.COM', 
                'roles' => [5],  
                'password' => '87081064' 
            ],
            [  
                'nrp' =>'89100520', 
                'email' => 'NDAREDY@GMAIL.COM', 
                'roles' => [5],  
                'password' => '89100520' 
            ],
            [  
                'nrp' =>'93060431', 
                'email' => 'MOHAMMADAGUNGSAPUTRA@GMAIL.COM', 
                'roles' => [5],  
                'password' => '93060431' 
            ],
            [  
                'nrp' =>'78110225', 
                'email' => 'NURHADI_KP3U@YAHOO.COM', 
                'roles' => [5],  
                'password' => '78110225' 
            ],
            [  
                'nrp' =>'84120973', 
                'email' => 'maryanata@bospolri.com', 
                'roles' => [5],  
                'password' => '84120973' 
            ],
            [  
                'nrp' =>'87020980', 
                'email' => 'MASDAYAT31@GMAIL.COM', 
                'roles' => [5],  
                'password' => '87020980' 
            ],
            [  
                'nrp' =>'77110726', 
                'email' => 'ROCHMANWAHYU_20@YAHOO.CO.ID', 
                'roles' => [5],  
                'password' => '77110726' 
            ],
            [  
                'nrp' =>'80050301', 
                'email' => 'sutiyono99@yahoo.co.id', 
                'roles' => [5],  
                'password' => '80050301' 
            ],
            [  
                'nrp' =>'84110866', 
                'email' => 'AHMADZULKIFLI84.AZ@GMAIL.COM', 
                'roles' => [5],  
                'password' => '84110866' 
            ],
            [  
                'nrp' =>'85081882', 
                'email' => 'POLRESKEPSERIBU@GMAIL.COM', 
                'roles' => [5],  
                'password' => '85081882' 
            ],
            [  
                'nrp' =>'77110893', 
                'email' => 'hermanto@bospolri.com', 
                'roles' => [5],  
                'password' => '77110893' 
            ],
            [  
                'nrp' =>'92110525', 
                'email' => 'butar@bospolri.com', 
                'roles' => [5],  
                'password' => '92110525' 
            ],
            [  
                'nrp' =>'78030909', 
                'email' => 'HPOERNOMO51@YAHOO.CO.ID', 
                'roles' => [5],  
                'password' => '78030909' 
            ],
            [  
                'nrp' =>'74020325', 
                'email' => 'iwansetyawan@gmail.com', 
                'roles' => [5],  
                'password' => '74020325' 
            ],
            [
                'nrp' =>'77081071',
                'email' => 'asepirpanrosadi99@gmail.com',
                'roles' => [5],
                'password' => '77081071'
            ],
            [  
                'nrp' =>'78050850', 
                'email' => 'PURNIAWANLDP@GMAIL.COM', 
                'roles' => [5],  
                'password' => '78050850' 
            ],
            [  
                'nrp' =>'67110407', 
                'email' => 'SUWARTO795@GMAIL.COM', 
                'roles' => [5],  
                'password' => '67110407' 
            ],
            [  
                'nrp' =>'77071033', 
                'email' => 'SIGIT.HARYANTO.ID@GMAIL.COM', 
                'roles' => [5],  
                'password' => '77071033' 
            ],
            [  'nrp' =>' 70120667', 'email' => 'ruslan@bospolri.com', 'roles' => [5],  'password' => '70120667' ],
            [  'nrp' =>' 76010519', 'email' => 'NUAR0132@GMAIL.COM', 'roles' => [5],  'password' => '76010519' ],
            [  'nrp' =>' 93110726', 'email' => 'ARIFMUHAMMAD.KSP@GMAIL.COM', 'roles' => [5],  'password' => '93110726' ],
            [  'nrp' =>' 64040999', 'email' => 'BUDIMANBIDKUMPOLDASUMUT@GMAIL.COM', 'roles' => [5],  'password' => '64040999' ],
            [  'nrp' =>' 95040790', 'email' => 'CHERDIKAA@YAHOO.COM', 'roles' => [5],  'password' => '95040790' ],
            [  'nrp' =>' 95040929', 'email' => 'isirenaja@gmail.com', 'roles' => [5],  'password' => '95040929' ],
            [  'nrp' =>' 82041131', 'email' => 'UPANK03@YAHOO.COM', 'roles' => [5],  'password' => '82041131' ],
            [  'nrp' =>'  84081233', 'email' => 'perta@bospolri.com', 'roles' => [5],  'password' => ' 84081233' ],
            [  'nrp' =>' 78050479', 'email' => 'SURYADARMASH@GMIAL.COM', 'roles' => [5],  'password' => '78050479' ],
            [  'nrp' =>' 75090793', 'email' => 'SIGIT_JEEP@YAHOO.CO.ID', 'roles' => [5],  'password' => '75090793' ],
            [  'nrp' =>' 73110621', 'email' => 'JAYABAKTI1441@GMAIL.COM', 'roles' => [5],  'password' => '73110621' ],
            [  'nrp' =>' 87031563', 'email' => 'PERDIJALNI7@GMAIL.COM', 'roles' => [5],  'password' => '87031563' ],
            [  'nrp' =>' 72040538', 'email' => 'AFRIYANIYANI61@YAHOO.COM', 'roles' => [5],  'password' => '72040538' ],
            [  'nrp' =>' 86091152', 'email' => 'AZRIMULYADI86@GMAIL.COM', 'roles' => [5],  'password' => '86091152' ],
            [  'nrp' =>' 91080229', 'email' => 'HARLANSASMITA91@GMAIL.COM', 'roles' => [5],  'password' => '91080229' ],
            [  'nrp' =>' 72080771', 'email' => 'KHOLILMUSTAFA17@GMAIL.COM', 'roles' => [5],  'password' => '72080771' ],
            [  'nrp' =>' 90100242', 'email' => 'NOVRIANSYAH72@GMAIL.COM', 'roles' => [5],  'password' => '90100242' ],
            [  'nrp' =>' 94020356', 'email' => 'Febidwiprayudha@gmail.com', 'roles' => [5],  'password' => '94020356' ],
            [  'nrp' =>' 65050305', 'email' => 'hadi@bospolri.com', 'roles' => [5],  'password' => '65050305' ],
            [  'nrp' =>' 82110087', 'email' => 'ENDRAWICAKSONO66@GMAIL.COM', 'roles' => [5],  'password' => '82110087' ],
            [  'nrp' =>' 97040647', 'email' => 'BAGUSSETYADI74@GMAIL.COM', 'roles' => [5],  'password' => '97040647' ],
            [  'nrp' =>' 71030350', 'email' => 'SKPT.SUMSEL@YAHOO.COM', 'roles' => [5],  'password' => '71030350' ],
            [  'nrp' =>' 84070618', 'email' => 'FADILAHFAJAR654@GMAIL.COM', 'roles' => [5],  'password' => '84070618' ],
            [  'nrp' =>' 85051904', 'email' => 'DOKTERVIVIN@GMAIL.COM', 'roles' => [5],  'password' => '85051904' ],
            [  'nrp' =>' 63110143', 'email' => 'HERNI.SISWATI1963@GMAIL.COM', 'roles' => [5],  'password' => '63110143' ],
            [  'nrp' =>' 88100079', 'email' => 'DUOBRIGADIR86@GMAIL.COM', 'roles' => [5],  'password' => '88100079' ],
            [  'nrp' =>' 96080705', 'email' => 'HASBIH950@GMAIL.COM', 'roles' => [5],  'password' => '96080705' ],
            [  'nrp' =>' 64100403', 'email' => 'www.ditnarkobalampung@ymail.com', 'roles' => [5],  'password' => '64100403' ],
            [  'nrp' =>' 86110303', 'email' => 'RAHMAD_NOVIYADI@YAHOO.CO.ID', 'roles' => [5],  'password' => '86110303' ],
            [  'nrp' =>' 87040933', 'email' => 'BENIOGASKA87@GMAIL.COM', 'roles' => [5],  'password' => '87040933' ],
            [  'nrp' =>' 71060491', 'email' => 'ANDARYOSO@POLRI.GO.ID', 'roles' => [5],  'password' => '71060491' ],
            [  'nrp' =>' 96070500', 'email' => 'wangsa@bospolri.com', 'roles' => [5],  'password' => '96070500' ],
            [  'nrp' =>' 94030234', 'email' => 'SULISTIYADIGINDRA@GAMIL.COM', 'roles' => [5],  'password' => '94030234' ],
            [  'nrp' =>' 74040764', 'email' => 'selipudjawijaya.se@gmail.com', 'roles' => [5],  'password' => '74040764' ],
            [  'nrp' =>' 80071428', 'email' => 'nurwanbowo@yahoo.co.id', 'roles' => [5],  'password' => '80071428' ],
            [  'nrp' =>' 90030145', 'email' => 'ELKA_NIRYAWAN@YAHOO.COM', 'roles' => [5],  'password' => '90030145' ],
            [  'nrp' =>' 64060873', 'email' => 'NETHSKADIVET@YMAIL.COM', 'roles' => [5],  'password' => '64060873' ],
            [  'nrp' =>' 78120356', 'email' => 'NATAKUSUMAH2898@GMAIL.COM', 'roles' => [5],  'password' => '78120356' ],
            [  'nrp' =>' 97070331', 'email' => 'MPRATAMAJUANDA40@GMAIL.COM', 'roles' => [5],  'password' => '97070331' ],
            [  'nrp' =>' 68100544', 'email' => 'YOEDHI9697@GMAIL.COM', 'roles' => [5],  'password' => '68100544' ],
            [  'nrp' =>' 67070050', 'email' => 'YTRISNANTO@GMAIL.COM', 'roles' => [5],  'password' => '67070050' ],
            [  'nrp' =>' 78020505', 'email' => 'CATUR@YAHOO.COM', 'roles' => [5],  'password' => '78020505' ],
            [  'nrp' =>' 65120055', 'email' => 'SRIKANDIYOGYA@YAHOO.CO.ID', 'roles' => [5],  'password' => '65120055' ],
            [  'nrp' =>' 81021083', 'email' => 'TONI.PURWANTO81@GMAIL.COM', 'roles' => [5],  'password' => '81021083' ],
            [  'nrp' =>' 94081113', 'email' => 'ANGGADWIP@GMAIL.COM', 'roles' => [5],  'password' => '94081113' ],
            [  'nrp' =>' 64110233', 'email' => 'MFATONI1965@GMAIL.COM', 'roles' => [5],  'password' => '64110233' ],
            [  'nrp' =>' 74080164', 'email' => 'N4Y427@GMAIL.COM', 'roles' => [5],  'password' => '74080164' ],
            [  'nrp' =>' 84091046', 'email' => 'FEBRI_AKHMAD@YAHOO.CO.ID', 'roles' => [5],  'password' => '84091046' ],
            [  'nrp' =>' 63070158', 'email' => 'KETUTDWIKORA@GMAIL.COM', 'roles' => [5],  'password' => '63070158' ],
            [  'nrp' =>' 95110201', 'email' => 'NOVENDIBUDI@GMAIL.COM', 'roles' => [5],  'password' => '95110201' ],
            [  'nrp' =>' 98010214', 'email' => 'NARENDRA.WIBAWA98@YAHOO.CO.ID', 'roles' => [5],  'password' => '98010214' ],
            [  'nrp' =>' 65050432', 'email' => 'koilmo@bospolri.com', 'roles' => [5],  'password' => '65050432' ],
            [  'nrp' =>' 79011203', 'email' => 'budherershi7986@gmail.com', 'roles' => [5],  'password' => '79011203' ],
            [  'nrp' =>' 94030589', 'email' => 'marnilette@gmail.com', 'roles' => [5],  'password' => '94030589' ],
            [  'nrp' =>' 67030631', 'email' => 'DICKY_ADITYA80@YAHOO.COM', 'roles' => [5],  'password' => '67030631' ],
            [  'nrp' =>' 89010362', 'email' => 'andikhuwailid32@gmail.com', 'roles' => [5],  'password' => '89010362' ],
            [  'nrp' =>' 92020339', 'email' => 'ROBERT.MONTOLALU27@GMAIL.COM', 'roles' => [5],  'password' => '92020339' ],
            [  'nrp' =>' 76061058', 'email' => 'AYUNKUSWANAJI2@GMAIL.COM', 'roles' => [5],  'password' => '76061058' ],
            [  'nrp' =>' 78050862', 'email' => 'GEALGEOLDOANK@GMAIL.COM', 'roles' => [5],  'password' => '78050862' ],
            [  'nrp' =>' 84050635', 'email' => 'MARJUTYA@GMAIL.COM', 'roles' => [5],  'password' => '84050635' ],
            [  'nrp' =>' 71110439', 'email' => 'RIAN_TOHARI98@YAHOO.COM', 'roles' => [5],  'password' => '71110439' ],
            [  'nrp' =>' 71110366', 'email' => 'AKHMAD.SAID71@GMAIL.COM', 'roles' => [5],  'password' => '71110366' ],
            [  'nrp' =>' 98080863', 'email' => 'SULTAN.HD25@GMAIL.COM', 'roles' => [5],  'password' => '98080863' ],
            [  'nrp' =>' 73010698', 'email' => 'HARISSUPRIYADI.SH.MH@GMAIL.COM', 'roles' => [5],  'password' => '73010698' ],
            [  'nrp' =>' 73050654', 'email' => 'AANDAMRAH@YAHOO.COM', 'roles' => [5],  'password' => '73050654' ],
            [  'nrp' =>' 86071158', 'email' => 'EKARUSMITAAGUSTINA@GMAIL.COM', 'roles' => [5],  'password' => '86071158' ],
            [  'nrp' =>' 64080135', 'email' => 'syaifodin@bospolri.com', 'roles' => [5],  'password' => '64080135' ],
            [  'nrp' =>' 87080932', 'email' => 'LEONARD231507@GMAIL.COM', 'roles' => [5],  'password' => '87080932' ],
            [  'nrp' =>' 85090532', 'email' => 'SUTOPOWIJAYA28@GMAIL.COM', 'roles' => [5],  'password' => '85090532' ],
            [  'nrp' =>' 73050577', 'email' => 'abdulkr1234@gmail.com', 'roles' => [5],  'password' => '73050577' ],
            [  'nrp' =>' 94100657', 'email' => 'ERICKPUTRAGIRISETIAWAN@GMAIL.COM', 'roles' => [5],  'password' => '94100657' ],
            [  'nrp' =>' 96010498', 'email' => 'BAGUSAJA986@GMAIL.COM', 'roles' => [5],  'password' => '96010498' ],
            [  'nrp' =>' 70060461', 'email' => 'HARISWELONG97@GMAIL.COM', 'roles' => [5],  'password' => '70060461' ],
            [  'nrp' =>' 86041699', 'email' => 'huliselanreimo@gmail.com', 'roles' => [5],  'password' => '86041699' ],
            [  'nrp' =>' 88070758', 'email' => 'AKKALLND88@GMAIL.COM', 'roles' => [5],  'password' => '88070758' ],
            [  'nrp' =>' 75020251', 'email' => 'MUH.IKHSAN1434@GMAIL.COM', 'roles' => [5],  'password' => '75020251' ],
            [  'nrp' =>' 84060145', 'email' => 'firdaus@bospolri.com', 'roles' => [5],  'password' => '84060145' ],
            [  'nrp' =>' 99110158', 'email' => 'richardo@bospolri.com', 'roles' => [5],  'password' => '99110158' ],
            [  'nrp' =>' 72050513', 'email' => 'SPNLABUAN.SULTENG@GMAIL.COM', 'roles' => [5],  'password' => '72050513' ],
            [  'nrp' =>' 84120225', 'email' => 'afandi@bospolri.com', 'roles' => [5],  'password' => '84120225' ],
            [  'nrp' =>' 83020804', 'email' => 'SATPAMPOLSUSPOLDASULTENG@GMAIL.COM', 'roles' => [5],  'password' => '83020804' ],
            [  'nrp' =>' 64120113', 'email' => 'SUTOPODJOJOSUMARTO@.GMAIL.GO.ID', 'roles' => [5],  'password' => '64120113' ],
            [  'nrp' =>' 92120935', 'email' => 'YANTOUMAR9231@GMAIL.COM', 'roles' => [5],  'password' => '92120935' ],
            [  'nrp' =>' 00090208', 'email' => 'mukmin@bospolri.com', 'roles' => [5],  'password' => '00090208' ],
            [  'nrp' =>' 63120165', 'email' => 'lumenta@bospolri.com', 'roles' => [5],  'password' => '63120165' ],
            [  'nrp' =>' 88041112', 'email' => 'MASWARNUR.68@GMAIL.COM', 'roles' => [5],  'password' => '88041112' ],
            [  'nrp' =>' 96080360', 'email' => 'ARIATIDIAMANIS43@GMAIL.COM', 'roles' => [5],  'password' => '96080360' ],
            [  'nrp' =>' 74010690', 'email' => 'YUSUFMARS@GMAIL.COM', 'roles' => [5],  'password' => '74010690' ],
            [  'nrp' =>' 81041289', 'email' => 'ADHARKENDARI2016@GMAIL.COM', 'roles' => [5],  'password' => '81041289' ],
            [  'nrp' =>' 99100536', 'email' => 'yusrilashari01@gmail.com', 'roles' => [5],  'password' => '99100536' ],
            [  'nrp' =>' 67100045', 'email' => 'BINMAS.POLDAMALUKU@GMAIL.COM', 'roles' => [5],  'password' => '67100045' ],
            [  'nrp' =>' 82090904', 'email' => 'binmas.poldamaluku@gmail.com', 'roles' => [5],  'password' => '82090904' ],
            [  'nrp' =>' 87070510', 'email' => 'ACHULUSTOM@GMAIL.COM', 'roles' => [5],  'password' => '87070510' ],
            [  'nrp' =>' 66010297', 'email' => 'imrans@gmail.com', 'roles' => [5],  'password' => '66010297' ],
            [  'nrp' =>' 84110762', 'email' => 'JUNET2004@GMAIL.COM', 'roles' => [5],  'password' => '84110762' ],
            [  'nrp' =>' 93030025', 'email' => 'DANNYCAMZTERZ.DC@GMAIL.COM', 'roles' => [5],  'password' => '93030025' ],
            [  'nrp' =>' 64050341', 'email' => 'resal@bospolri.com', 'roles' => [5],  'password' => '64050341' ],
            [  'nrp' =>' 97020265', 'email' => 'benmaditbinmaspoldapb@gmail.com', 'roles' => [5],  'password' => '97020265' ],
            [  'nrp' =>' 97080583', 'email' => 'firman@bospolri.com', 'roles' => [5],  'password' => '97080583' ],
            [  'nrp' =>' 65090398', 'email' => 'kaharudin@bospolri.com', 'roles' => [5],  'password' => '65090398' ],
            [  'nrp' =>' 80120687', 'email' => 'HERDY.IBRAHIM@YAHOO.COM', 'roles' => [5],  'password' => '80120687' ],
            [  'nrp' =>' 91110163', 'email' => 'makabori33@gmail.com', 'roles' => [5],  'password' => '91110163' ],
            [  'nrp' =>' 96061067', 'email' => 'DARMASP41@GMAIL.COM', 'roles' => [5],  'password' => '96061067' ],
            [  'nrp' =>' 97080564', 'email' => 'ariardana42@gmail.com', 'roles' => [5],  'password' => '97080564' ],
            [  'nrp' =>' 98060195', 'email' => 'ADISANJAYA385@GMAIL.COM', 'roles' => [5],  'password' => '98060195' ],
            [  'nrp' =>' 99110367', 'email' => 'muhammadelmaliki.99@gmail.com', 'roles' => [5],  'password' => '99110367' ],
            [  'nrp' =>' 99070711', 'email' => 'teukurafkiabetsya@gmail.com', 'roles' => [5],  'password' => '99070711' ],
            [  'nrp' =>' 66120586', 'email' => 'HADISISWO101@GMAIL.COM', 'roles' => [5],  'password' => '66120586' ],
            [  'nrp' =>' 94100646', 'email' => 'MUKSINGOMBEL@YAHOO.CO.ID', 'roles' => [5],  'password' => '94100646' ],
            [  'nrp' =>' 82040616', 'email' => 'irvan@bospolri.com', 'roles' => [5],  'password' => '82040616' ],
            [  'nrp' =>' 87011349', 'email' => 'faisal@bospolri.com', 'roles' => [5],  'password' => '87011349' ],
            [  'nrp' =>' 82110961', 'email' => 'BOYKESIMARMATA@GMAIL.COM', 'roles' => [5],  'password' => '82110961' ],
            [  'nrp' =>' 83090977', 'email' => 'HASANUDINWAHYUDI13@GMAIL.COM', 'roles' => [5],  'password' => '83090977' ],
            [  'nrp' =>' 77060263', 'email' => 'AGUSMERUYA1717@YAHOO.COM', 'roles' => [5],  'password' => '77060263' ],
            [  'nrp' =>' 83010806', 'email' => 'ARISPOSPOL@GMAIL.COM', 'roles' => [5],  'password' => '83010806' ],
            [  'nrp' =>' 80071304', 'email' => 'TAMAMLDT@GMAIL.COM', 'roles' => [5],  'password' => '80071304' ],
            [  'nrp' =>' 83120871', 'email' => 'TEGUHWI77@GMAIL.COM', 'roles' => [5],  'password' => '83120871' ],
            [  'nrp' =>' 75020161', 'email' => 'muin@bospolri.com', 'roles' => [5],  'password' => '75020161' ],
            [  'nrp' =>' 77070427', 'email' => 'sigit@bospolri.com', 'roles' => [5],  'password' => '77070427' ],
            [  'nrp' =>' 75030237', 'email' => 'SRIYONO12352@GMAIL.COM', 'roles' => [5],  'password' => '75030237' ],
            [  'nrp' =>' 73060562', 'email' => 'AAOMAT86@GMAIL.COM', 'roles' => [5],  'password' => '73060562' ],
            [  'nrp' =>' 79100331', 'email' => 'MURYANTO.HM@GMAIL.COM', 'roles' => [5],  'password' => '79100331' ],
            [  'nrp' =>' 84020111', 'email' => 'FEBRIOK1984@GMAIL.COM', 'roles' => [5],  'password' => '84020111' ],
            [  'nrp' =>' 77100624', 'email' => 'wahyono@bospolri.com', 'roles' => [5],  'password' => '77100624' ],
            [  'nrp' =>' 84070345', 'email' => 'AGUNGMF_84@YAHOO.COM', 'roles' => [5],  'password' => '84070345' ],
            [  'nrp' =>' 86020087', 'email' => 'RESKYJUWITA@GMAIL.COM', 'roles' => [5],  'password' => '86020087' ],
            [  'nrp' =>' 78120290', 'email' => 'kuzairi@bospolri.com', 'roles' => [5],  'password' => '78120290' ],
            [  'nrp' =>' 83010091', 'email' => 'ALFATIHQUA@GMAIL.COM', 'roles' => [5],  'password' => '83010091' ],
            [  'nrp' =>' 77100501', 'email' => 'TRIYONO88YAHOO@GMAIL.COM', 'roles' => [5],  'password' => '77100501' ],
            [  'nrp' =>' 82081069', 'email' => 'BHABIN.BANTARJAYA@GMAIL.COM', 'roles' => [5],  'password' => '82081069' ],
            [  'nrp' =>' 84021375', 'email' => 'RENDRAANGGA@GMAIL.COM', 'roles' => [5],  'password' => '84021375' ],
            [  'nrp' =>' 87081064', 'email' => 'ADEHARYONO999@GMAIL.COM', 'roles' => [5],  'password' => '87081064' ],
            [  'nrp' =>' 89100520', 'email' => 'NDAREDY@GMAIL.COM', 'roles' => [5],  'password' => '89100520' ],
            [  'nrp' =>' 93060431', 'email' => 'MOHAMMADAGUNGSAPUTRA@GMAIL.COM', 'roles' => [5],  'password' => '93060431' ],
            [  'nrp' =>' 78110225', 'email' => 'NURHADI_KP3U@YAHOO.COM', 'roles' => [5],  'password' => '78110225' ],
            [  'nrp' =>' 84120973', 'email' => 'maryanata@bospolri.com', 'roles' => [5],  'password' => '84120973' ],
            [  'nrp' =>' 87020980', 'email' => 'MASDAYAT31@GMAIL.COM', 'roles' => [5],  'password' => '87020980' ],
            [  'nrp' =>' 77110726', 'email' => 'ROCHMANWAHYU_20@YAHOO.CO.ID', 'roles' => [5],  'password' => '77110726' ],
            [  'nrp' =>' 80050301', 'email' => 'sutiyono99@yahoo.co.id', 'roles' => [5],  'password' => '80050301' ],
            [  'nrp' =>' 84110866', 'email' => 'AHMADZULKIFLI84.AZ@GMAIL.COM', 'roles' => [5],  'password' => '84110866' ],
            [  'nrp' =>' 85081882', 'email' => 'POLRESKEPSERIBU@GMAIL.COM', 'roles' => [5],  'password' => '85081882' ],
            [  'nrp' =>' 77110839', 'email' => 'hermanto@bospolri.com', 'roles' => [5],  'password' => '77110839' ],
            [  'nrp' =>' 92110525', 'email' => 'butar@bospolri.com', 'roles' => [5],  'password' => '92110525' ],
            [  'nrp' =>' 78030909', 'email' => 'HPOERNOMO51@YAHOO.CO.ID', 'roles' => [5],  'password' => '78030909' ],
            [  'nrp' =>' 74020325', 'email' => 'iwansetyawan@gmail.com', 'roles' => [5],  'password' => '74020325' ],
            [  'nrp' =>' 78050850', 'email' => 'PURNIAWANLDP@GMAIL.COM', 'roles' => [5],  'password' => '78050850' ],
            [  'nrp' =>' 67110407', 'email' => 'SUWARTO795@GMAIL.COM', 'roles' => [5],  'password' => '67110407' ],
            [  'nrp' =>' 77071033', 'email' => 'SIGIT.HARYANTO.ID@GMAIL.COM', 'roles' => [5],  'password' => '77071033' ],
            
        ];
//        DB::table('users')->truncate();
//        DB::table('role_user')->truncate();

        foreach($datas as $key => $data){
            $newUser = User::updateOrCreate([
                'email' => $data['email'],
            ], [
                'nrp' => $data['nrp'] ?? null,
                'password' => bcrypt($data['password'])
            ]);
            $newUser->roles()->sync($data['roles'] ?? []);
        }
        
    }
}
