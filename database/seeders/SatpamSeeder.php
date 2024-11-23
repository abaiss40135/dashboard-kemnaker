<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SatpamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('satpams')->truncate();
        \Illuminate\Support\Facades\DB::statement("
            INSERT INTO satpams (id, nama, no_ktp, no_kta, jenis_kelamin, user_id, detail_alamat, provinsi, kabupaten, kecamatan, desa, rt, rw, tempat_lahir, tanggal_lahir, agama, no_hp, bujp_id, tempat_tugas, tanggal_terbit_kta, foto_kta, created_at, updated_at)
                VALUES (1, 'Julianto', '3602110306990005', '123', 'laki-laki', 6, 'Kp. Jampang Hilir', 'BANTEN', 'KABUPATEN LEBAK', 'CIMARGA', 'MARGALUYU', '004', '005', 'Lebak', '1999-03-07', 'Islam', '08118228835', 1, 'Menara Bidakara', '2021-04-04', 'https://storage.googleapis.com/bos-production/satpam/foto_kta/1617616065photo_2021-04-05_16-38-10.jpg', '2021-04-05 09:47:45', '2021-04-05 09:47:45'),
                    (2, 'Aldi Rosyid', '379999990000', '865598605690', 'laki-laki', 7, 'Jl Anggur', 'DKI JAKARTA', 'KOTA JAKARTA TIMUR', 'CIRACAS', 'KELAPA DUA WETAN', '3', '12', 'Jakarta', '1999-12-04', 'Islam', '089653121403', 1, 'Mall Cijantung', '2020-12-12', 'https://storage.googleapis.com/bos-production/satpam/foto_kta/1617632537aldi.jpg', '2021-04-05 14:22:17', '2021-04-05 14:22:17'),
                    (3, 'Aziz', '3602110306990005', '1234', 'laki-laki', 8, 'Kp. Jampang Hilir', 'BANTEN', 'KABUPATEN LEBAK', 'CIHARA', 'PONDOKPANJANG', '002', '003', 'Lebak', '2000-07-07', 'Islam', '08118228836', 1, 'Menara Bidakara', '2021-06-04', 'https://storage.googleapis.com/bos-production/satpam/foto_kta/1617675945photo_2021-04-05_16-38-10.jpg', '2021-04-06 02:25:45', '2021-04-06 02:25:45'),
                    (4, 'Satria', '3602110306990008', '12345', 'laki-laki', 9, 'Kp. kedongsongo', 'JAWA TENGAH', 'KABUPATEN JEPARA', 'KALINYAMATAN', 'MANYARGADING', '002', '003', 'Jepara', '2002-11-07', 'Islam', '08118228837', 1, 'Menara Bidakara', '1999-06-04', 'https://storage.googleapis.com/bos-production/satpam/foto_kta/1617676177photo_2021-04-05_16-38-10.jpg', '2021-04-06 02:29:37', '2021-04-06 02:29:37'),
                    (5, 'Haris Dermawan', '3602110306990008', '123456', 'laki-laki', 10, 'Kp. Cibuah', 'BANTEN', 'KABUPATEN LEBAK', 'WARUNGGUNUNG', 'CIBUAH', '002', '005', 'Lebak', '1996-09-09', 'Islam', '08118228837', 1, 'Menara Bidakara', '2021-06-04', 'https://storage.googleapis.com/bos-production/satpam/foto_kta/1617676395photo_2021-04-05_16-38-10.jpg', '2021-04-06 02:33:15', '2021-04-06 02:33:15'),
                    (6, 'Adit', '3602110306990008', '1234567', 'laki-laki', 11, 'Kp. kedongsongo', 'JAWA TENGAH', 'KABUPATEN SEMARANG', 'JAMBU', 'REJOSARI', '002', '003', 'Kedongsongo', '2000-04-04', 'Islam', '08118228837', 1, 'Menara Bidakara', '2021-12-03', 'https://storage.googleapis.com/bos-production/satpam/foto_kta/1617696182photo_2021-04-05_16-38-10.jpg', '2021-04-06 08:03:03', '2021-04-06 08:03:03'),
                    (7, 'Rudi', '3602110306990009', '1234568', 'laki-laki', 12, 'Kp. kedongsongo', 'JAWA TENGAH', 'KOTA SEMARANG', 'PEDURUNGAN', 'TLOGOSARI KULON', '002', '005', 'Semarang', '1999-03-07', 'Islam', '08118228839', 1, 'Menara Bidakara', '2021-04-04', 'https://storage.googleapis.com/bos-production/satpam/foto_kta/1617696563photo_2021-04-05_16-38-10.jpg', '2021-04-06 08:09:24', '2021-04-06 08:09:24'),
                    (8, 'Jamal', '3602110306990009', '1234567', 'laki-laki', 13, 'Kp. Kaum', 'BANTEN', 'KABUPATEN LEBAK', 'RANGKASBITUNG', 'RANGKASBITUNG TIMUR', '002', '001', 'Lebak', '1998-04-09', 'Islam', '08118228888', 1, 'Menara Bidakara', '2021-09-03', 'https://storage.googleapis.com/bos-production/satpam/foto_kta/1617699729photo_2021-04-05_16-38-10.jpg', '2021-04-06 09:02:10', '2021-04-06 09:02:10');
        ");
    }
}
