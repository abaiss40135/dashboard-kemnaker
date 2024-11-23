<?php

namespace Database\Seeders;

use App\Models\Personel;
use App\Models\Sislap\Lapsubjar\Bintibsos\SakaBhayangkara;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SakaBhayangkaraApprovalSeeder extends Seeder
{
    public function run()
    {
        $laporanA = [
            [
                'uraian'     => 'Pelaksanaan Perkemahan antar Saka 2021 ',
                'sasaran'    => 'Seluruh saka anggota Saka Bhayangkara ',
                'hasil'      => 'Terjalinnya silaturahmi yang erat antar Saka di ',
                'keterangan' => 'Pelaksanaan kegiatan berjalan dengan baik',
            ],
            [
                'uraian'     => 'Lomba Saka Bhayangkara ',
                'sasaran'    => 'Seluruh anggota Saka Bhayangkara ',
                'hasil'      => 'Mengasah kompetensi anggota Saka Bhayangkara ',
                'keterangan' => 'Pelaksanaan kegiatan berjalan dengan baik',
            ],
            [
                'uraian'     => 'Latihan Gabungan (Latgab) Saka Bhayangkara 2021 ',
                'sasaran'    => 'Perwakilan terbaik anggota Saka Bhayangkara ',
                'hasil'      => 'Terbentuknya standar pelatihan gabungan Saka Bhayangkara ',
                'keterangan' => 'Pelaksanaan kegiatan tereschedule karena cuaca buruk',
            ],
        ];

        $laporanB = [
            [
                'uraian'     => 'Pelaksanaan Perkemahan antar Saka 2021 ',
                'sasaran'    => 'Seluruh saka anggota Saka Bhayangkara ',
                'hasil'      => 'Terjalinnya silaturahmi yang erat antar Saka di ',
                'keterangan' => 'Pelaksanaan kegiatan berjalan dengan baik',
            ],
            [
                'uraian'     => 'Lomba Saka Bhayangkara ',
                'sasaran'    => 'Seluruh anggota Saka Bhayangkara ',
                'hasil'      => 'Mengasah kompetensi anggota Saka Bhayangkara ',
                'keterangan' => 'Pelaksanaan kegiatan berjalan dengan baik',
            ],
            [
                'uraian'     => 'Latihan Gabungan (Latgab) Saka Bhayangkara 2021 ',
                'sasaran'    => 'Perwakilan terbaik anggota Saka Bhayangkara ',
                'hasil'      => 'Terbentuknya standar pelatihan gabungan Saka Bhayangkara ',
                'keterangan' => 'Pelaksanaan kegiatan direschedule karena cuaca buruk',
            ]
        ];

        $keterangan_approval = 'Laporan diajukan untuk approval ke tingkat polda';

        $datas = [
            [ 'kode_satuan' =>  '20118','polres' =>  'POLRES ACEH BARAT'],
            [ 'kode_satuan' =>  '20119','polres' =>  'POLRES ACEH BARAT DAYA'],
            [ 'kode_satuan' =>  '20218','polres' =>  'POLRES ASAHAN'],
            [ 'kode_satuan' =>  '20219','polres' =>  'POLRES BATU BARA'],
            [ 'kode_satuan' =>  '20320','polres' =>  'POLRES BUKITTINGGI'],
            [ 'kode_satuan' =>  '20321','polres' =>  'POLRES DHARMASRAYA'],
            [ 'kode_satuan' =>  '20427','polres' =>  'POLRES ROKAN HULU'],
            [ 'kode_satuan' =>  '20428','polres' =>  'POLRES SIAK'],
            [ 'kode_satuan' =>  '20518','polres' =>  'POLRES BINTAN'],
            [ 'kode_satuan' =>  '20519','polres' =>  'POLRES KARIMUN'],
            [ 'kode_satuan' =>  '20621','polres' =>  'POLRES LUBUK LINGGAU'],
            [ 'kode_satuan' =>  '20622','polres' =>  'POLRES MUARA ENIM'],
            [ 'kode_satuan' =>  '20824','polres' =>  'POLRES MUKO MUKO'],
            [ 'kode_satuan' =>  '20825','polres' =>  'POLRES REJANG LEBONG'],
            [ 'kode_satuan' =>  '20920','polres' =>  'POLRES KERINCI'],
            [ 'kode_satuan' =>  '20921','polres' =>  'POLRES MERANGIN'],
            [ 'kode_satuan' =>  '21027','polres' =>  'POLRES TULANG BAWANG'],
            [ 'kode_satuan' =>  '21028','polres' =>  'POLRES WAY KANAN'],
            [ 'kode_satuan' =>  '21118','polres' =>  'POLRES KEPULAUAN SERIBU'],
            [ 'kode_satuan' =>  '21120','polres' =>  'POLRES METRO BEKASI'],
            [ 'kode_satuan' =>  '21220','polres' =>  'POLRES BOGOR'],
            [ 'kode_satuan' =>  '21221','polres' =>  'POLRES CIAMIS'],
            [ 'kode_satuan' =>  '21319','polres' =>  'POLRES LEBAK'],
            [ 'kode_satuan' =>  '21320','polres' =>  'POLRES PANDEGLANG'],
            [ 'kode_satuan' =>  '21420','polres' =>  'POLRES BATANG'],
            [ 'kode_satuan' =>  '21421','polres' =>  'POLRES BLORA'],
            [ 'kode_satuan' =>  '21520','polres' =>  'POLRES KULON PROGO'],
            [ 'kode_satuan' =>  '21521','polres' =>  'POLRES SLEMAN'],
            [ 'kode_satuan' =>  '21620','polres' =>  'POLRES BATU'],
            [ 'kode_satuan' =>  '21621','polres' =>  'POLRES BLITAR'],
            [ 'kode_satuan' =>  '21721','polres' =>  'POLRES KETAPANG'],
            [ 'kode_satuan' =>  '21722','polres' =>  'POLRES LANDAK'],
            [ 'kode_satuan' =>  '21825','polres' =>  'POLRES KOTABARU'],
            [ 'kode_satuan' =>  '21826','polres' =>  'POLRES TABALONG'],
            [ 'kode_satuan' =>  '21922','polres' =>  'POLRES KAPUAS'],
            [ 'kode_satuan' =>  '21923','polres' =>  'POLRES KATINGAN'],
            [ 'kode_satuan' =>  '22020','polres' =>  'POLRES BONTANG'],
            [ 'kode_satuan' =>  '22021','polres' =>  'POLRES KUTAI BARAT'],
            [ 'kode_satuan' =>  '22221','polres' =>  'POLRES GIANYAR'],
            [ 'kode_satuan' =>  '22222','polres' =>  'POLRES JEMBRANA'],
            [ 'kode_satuan' =>  '22320','polres' =>  'POLRES DOMPU'],
            [ 'kode_satuan' =>  '22321','polres' =>  'POLRES LOMBOK BARAT'],
            [ 'kode_satuan' =>  '22424','polres' =>  'POLRES LEMBATA'],
            [ 'kode_satuan' =>  '22425','polres' =>  'POLRES MANGGARAI'],
            [ 'kode_satuan' =>  '22523','polres' =>  'POLRES GOWA'],
            [ 'kode_satuan' =>  '22524','polres' =>  'POLRES JENEPONTO'],
            [ 'kode_satuan' =>  '22721','polres' =>  'POLRES DONGGALA'],
            [ 'kode_satuan' =>  '22723','polres' =>  'POLRES PALU'],
            [ 'kode_satuan' =>  '22821','polres' =>  'POLRES KOTAMOBAGU'],
            [ 'kode_satuan' =>  '22822','polres' =>  'POLRES MINAHASA'],
            [ 'kode_satuan' =>  '23120','polres' =>  'POLRES MALUKU TENGAH'],
            [ 'kode_satuan' =>  '23124','polres' =>  'POLRES PULAU BURU'],
            [ 'kode_satuan' =>  '23329','polres' =>  'POLRES MAPPI'],
            [ 'kode_satuan' =>  '23330','polres' =>  'POLRES MERAUKE'],
            [ 'kode_satuan' =>  '23536','polres' =>  'POLRES TIDORE'],
            [ 'kode_satuan' =>  '23537','polres' =>  'POLRES TERNATE'],
            [ 'kode_satuan' =>  '23631','polres' =>  'POLRES MAJENE'],
            [ 'kode_satuan' =>  '23632','polres' =>  'POLRES MAMASA'],
            [ 'kode_satuan' =>  '23702','polres' =>  'POLRES BONE BOLANGO'],
            [ 'kode_satuan' =>  '23703','polres' =>  'POLRES GORONTALO'],
            [ 'kode_satuan' =>  '23829','polres' =>  'POLRES BULUNGAN'],
            [ 'kode_satuan' =>  '23830','polres' =>  'POLRES MALINAU'],
            [ 'kode_satuan' =>  '23905','polres' =>  'POLRES KAIMANA'],
            [ 'kode_satuan' =>  '23906','polres' =>  'POLRES SORONG'],
            [ 'kode_satuan' =>  '24001','polres' =>  'POLRES BANGKA'],
            [ 'kode_satuan' =>  '24005','polres' =>  'POLRES BELITUNG'],
            [ 'kode_satuan' =>  '24111','polres' =>  'POLRES MUNA'],
            [ 'kode_satuan' =>  '24112','polres' =>  'POLRES WAKATOBI']
        ];

        DB::beginTransaction();
        try {
            foreach ($datas as $key => $data) {
                $laporans = $key % 2 == 0 ? $laporanA : $laporanB;
                foreach ($laporans as $laporan){
                    $saka = SakaBhayangkara::create([
                        'kode_satuan'   => $data['kode_satuan'],
                        'keterangan'    => $laporan['keterangan'],
                        'hasil'         => $laporan['hasil'] . $data['polres'],
                        'sasaran'       => $laporan['sasaran'] . $data['polres'],
                        'kesatuan'      => $data['polres'],
                        'uraian'        => $laporan['uraian'] . $data['polres'],
                        'user_id'       => 68691
                    ]);
                    $saka->approvals()->create([
                        'level'         => 'polres',
                        'keterangan'    => $keterangan_approval,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }
}
