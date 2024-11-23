<?php

namespace Database\Seeders;

use App\Models\StatusSio;
use Illuminate\Database\Seeder;

class StatusSioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            'Dokumen Sudah <br> Diterima oleh Polda',
            'Dokumen Telah <br>Diverifikasi oleh Polda',
            'Lulus Audit Rekomendasi <br> dan Terbit Surat Rekomendasi <br> di Tingkat Polda',
            'Dokumen Diverifikasi <br>oleh Operator Mabes Polri',
            'Dokumen diproses <br> oleh BKPM',
            'Surat Izin Operasional Terbit'
        ];

        foreach ($datas as $data) {
            StatusSio::firstOrCreate(['status' => $data]);
        }
    }
}
