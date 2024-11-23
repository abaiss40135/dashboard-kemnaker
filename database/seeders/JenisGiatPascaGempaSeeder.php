<?php

namespace Database\Seeders;

use App\Models\Sislap\Nonlapbul\PascaGempaCianjur\JenisGiatPascaGempa;
use App\Models\Sislap\Nonlapbul\PascaGempaCianjur\JenisLaporanPascaGempa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JenisGiatPascaGempaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_kegiatan = [
            [
                'giat' => 'PENGGALANGAN BANTUAN',
                'jenis' => [
                    'PENANGANGAN', 'BANTUAN'
                ],
            ],
            [
                'giat' => 'PENYERAHAN BANSOS',
                'jenis' => [
                    'BANTUAN'
                ],
            ],
            [
                'giat' => 'PENGAWALAN BANSOS',
                'jenis' => [
                    'BANTUAN'
                ],
            ],
            [
                'giat' => 'PENGIRIMAN RELAWAN',
                'jenis' => [
                    'BANTUAN'
                ],
            ],
            [
                'giat' => 'EVAKUASI',
                'jenis' => [
                    'PENANGANAN'
                ],
            ],
            [
                'giat' => 'SOSIALISASI',
                'jenis' => [
                    'PENANGANAN'
                ],
            ],
            [
                'giat' => 'EDUKASI',
                'jenis' => [
                    'PENANGANAN'
                ],
            ],
            [
                'giat' => 'BANSOS (PENDISTRIBUSIAN BANTUAN)',
                'jenis' => [
                    'PENANGANAN'
                ],
            ],
            [
                'giat' => 'TRAUMA HEALING',
                'jenis' => [
                    'PENANGANAN'
                ],
            ],
            [
                'giat' => 'BAKSOS',
                'jenis' => [
                    'PENANGANAN'
                ],
            ],
            [
                'giat' => 'YANKES',
                'jenis' => [
                    'PENANGANAN'
                ],
            ],
            [
                'giat' => 'PAM',
                'jenis' => [
                    'PENANGANAN'
                ],
            ],
        ];
        foreach ($jenis_kegiatan as $giat) {
            $new = JenisGiatPascaGempa::updateOrCreate(['slug' => Str::slug($giat['giat'])], [
                'nama'      => $giat['giat'],
                'created_by'=> 68691
            ]);
            foreach ($giat['jenis'] as $jenis) {
                JenisLaporanPascaGempa::firstOrCreate([
                    'jenis_giat_pasca_gempa_id' => $new->id,
                    'jenis_laporan' => $jenis
                ]);
            }
        }
    }
}
