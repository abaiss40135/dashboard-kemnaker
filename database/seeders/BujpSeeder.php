<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BujpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('bujps')->truncate();
        \Illuminate\Support\Facades\DB::statement("
            insert into bujps (id, nama_badan_usaha, tipe_badan_usaha, provinsi, kabupaten, kecamatan, desa, detail_alamat, kode_pos, nomor_telepon, website_badan_usaha, npwp_badan_usaha, logo_badan_usaha, bidang_usaha, panggilan_penanggung_jawab, nama_penanggung_jawab, nomor_ktp_penanggung_jawab, nomor_telepon_penanggung_jawab, jabatan_penanggung_jawab, foto_penanggung_jawab, foto_ktp_penanggung_jawab, created_at, updated_at, user_id)
                values  (1, 'PT. JATIDIRI MANDIRI', 'PT', 'DKI JAKARTA', 'KOTA JAKARTA SELATAN', 'PASAR MINGGU', 'PEJATEN BARAT', 'Gd. Inti Fauzi, B Floor, Jl. Buncit Raya No.22 – Pejaten, Jakarta', '12510', '02179182233','https://intifauzi.com', '42537467', 'https://storage.googleapis.com/bos-production/bujp/PT.%20JATIDIRI%20MANDIRI/logo/1617615710logo-div-humas.webp', 'Usaha Jasa Penerapan Peralatan Keamanan', 'Bapak', 'JULIANTO', '302110306990005', '08118228835', 'Direktur Utama', 'https://storage.googleapis.com/bos-production/bujp/PT.%20JATIDIRI%20MANDIRI/foto_penanggung_jawab/1617615710photo_2021-04-05_16-38-10.jpg', 'https://storage.googleapis.com/bos-production/bujp/PT.%20JATIDIRI%20MANDIRI/ktp_penanggung_jawab/1617615710photo_2021-04-05_16-39-34.jpg', '2021-04-06 23:05:06', '2021-04-06 23:05:09', 17);
        ");
    }
}
