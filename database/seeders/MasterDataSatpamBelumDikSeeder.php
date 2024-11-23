<?php

namespace Database\Seeders;

use App\Imports\Sislap\ReadRows;
use App\Models\Sislap\Lapsubjar\Binkamsa\MasterDataSatpamBelumDik;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MasterDataSatpamBelumDikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($polda = null)
    {
        $personels = [
            'POLDA DIY' => [
              'id' => '110368',
              'kode_satuan' => '215',
              'nrp' => '01010428',
            ],
            'POLDA JABAR' => [
              'id' => '99650',
              'kode_satuan' => '212',
              'nrp' => '01060739',
            ],
            'POLDA SUMUT' => [
              'id' => '92847',
              'kode_satuan' => '202',
              'nrp' => '64120956',
            ],
            'POLDA KALSEL' => [
              'id' => '100704',
              'kode_satuan' => '218',
              'nrp' => '65030169',
            ],
            'POLDA SULUT' => [
              'id' => '101316',
              'kode_satuan' => '228',
              'nrp' => '68120267',
            ],
            'POLDA PAPUA' => [
              'id' => '86303',
              'kode_satuan' => '233',
              'nrp' => '70020282',
            ],
            'POLDA PAPUA BARAT' => [
              'id' => '98741',
              'kode_satuan' => '239',
              'nrp' => '70060345',
            ],
            'POLDA NTB' => [
              'id' => '119515',
              'kode_satuan' => '223',
              'nrp' => '74080730',
            ],
            'POLDA KALTARA' => [
              'id' => '86476',
              'kode_satuan' => '238',
              'nrp' => '75010586',
            ],
            'POLDA JATIM' => [
              'id' => '86362',
              'kode_satuan' => '216',
              'nrp' => '77030343',
            ],
            'POLDA JAMBI' => [
              'id' => '107873',
              'kode_satuan' => '209',
              'nrp' => '81041437',
            ],
            'POLDA KALTENG' => [
              'id' => '132045',
              'kode_satuan' => '219',
              'nrp' => '82020445',
            ],
            'POLDA MALUKU' => [
              'id' => '85493',
              'kode_satuan' => '231',
              'nrp' => '82090904',
            ],
            'POLDA BENGKULU' => [
              'id' => '99634',
              'kode_satuan' => '208',
              'nrp' => '83080268',
            ],
            'POLDA NTT' => [
              'id' => '118678',
              'kode_satuan' => '224',
              'nrp' => '84050295',
            ],
            'POLDA SULBAR' => [
              'id' => '86905',
              'kode_satuan' => '236',
              'nrp' => '84060145',
            ],
            'POLDA KEPRI' => [
              'id' => '102066',
              'kode_satuan' => '205',
              'nrp' => '86050873',
            ],
            'POLDA LAMPUNG' => [
              'id' => '67498',
              'kode_satuan' => '210',
              'nrp' => '86050900',
            ],
            'POLDA SULTENG' => [
              'id' => '86522',
              'kode_satuan' => '227',
              'nrp' => '86080768',
            ],
            'POLDA RIAU' => [
              'id' => '99633',
              'kode_satuan' => '204',
              'nrp' => '87030127',
            ],
            'POLDA KALTIM' => [
              'id' => '99679',
              'kode_satuan' => '220',
              'nrp' => '90070239',
            ],
            'POLDA KALBAR' => [
              'id' => '101445',
              'kode_satuan' => '217',
              'nrp' => '94030903',
            ],
            'POLDA SUMBAR' => [
              'id' => '101068',
              'kode_satuan' => '203',
              'nrp' => '94050209',
            ],
            'POLDA SULTRA' => [
              'id' => '127268',
              'kode_satuan' => '241',
              'nrp' => '95020759',
            ],
            'POLDA BALI' => [
              'id' => '99670',
              'kode_satuan' => '222',
              'nrp' => '95050499',
            ],
            'POLDA JATENG' => [
              'id' => '125549',
              'kode_satuan' => '214',
              'nrp' => '96010439',
            ],
            'POLDA SUMSEL' => [
              'id' => '100710',
              'kode_satuan' => '206',
              'nrp' => '96110247',
            ],
            'POLDA SULSEL' => [
              'id' => '131792',
              'kode_satuan' => '225',
              'nrp' => '97040033',
            ],
            'POLDA ACEH' => [
              'id' => '118675',
              'kode_satuan' => '201',
              'nrp' => '97040275',
            ],
            'POLDA METRO JAYA' => [
              'id' => '101985',
              'kode_satuan' => '211',
              'nrp' => '97080075',
            ],
            'POLDA MALUT' => [
              'id' => '100736',
              'kode_satuan' => '235',
              'nrp' => '97120655',
            ],
            'POLDA BANTEN' => [
              'id' => '131238',
              'kode_satuan' => '213',
              'nrp' => '98020264',
            ],
            'POLDA KEP. BABEL' => [
              'id' => '99641',
              'kode_satuan' => '240',
              'nrp' => '99020077',
            ],
            'POLDA GORONTALO' => [
              'id' => '99690',
              'kode_satuan' => '237',
              'nrp' => '99090625',
            ],
        ];

        if (!$polda) {
            echo 'POLDA is not set\n';

            return;
        }

        $personel = $personels[$polda];

        if (!$personel) {
            echo 'POLDA is not found\n';

            return;
        }

        $level = 'polda';
        $file = resource_path('excels'.DIRECTORY_SEPARATOR.'satpam'.DIRECTORY_SEPARATOR.'belum-dik'.DIRECTORY_SEPARATOR."$polda.xlsx");
        $data = Excel::toArray(new ReadRows(), $file)[0];
        array_shift($data);

        DB::transaction(function () use ($level, $personel, $data) {
            foreach ($data as $item) {
                $mappped = [
                    'nama' => $item[1] == '-' ? null : $item[1],
                    'perusahaan' => $item[2] == '-' ? null : $item[2],
                    'tanggal_lahir' => $item[3] == '-' ? null : $item[3],
                    'jenis_kelamin' => $item[4] == '-' ? null : $item[4],
                    'lama_bertugas' => $item[5] == '-' ? null : substr($item[5], 0, 255),
                    'dikum_terakhir' => $item[6] == '-' ? null : $item[6],
                    'user_id' => $personel['id'],
                    'kode_satuan' => $personel['kode_satuan'],
                ];

                $laporan = MasterDataSatpamBelumDik::create($mappped);

                $laporan->approvals()->create([
                    'keterangan' => 'Laporan diajukan untuk approval mandiri oleh polda',
                    'level' => $level,
                ]);
            }
        });
    }
}
