<?php

namespace Database\Seeders;

use App\Models\Sislap\Nonlapbul\KegiatanCegahTindakPidanaKamtibmas\ListKegiatan;
use Illuminate\Database\Seeder;

class LapharKegiatanCegahTindakPidanaKamtibmasSeeder extends Seeder
{

    private $kegiatan = [
        "BINLUH/ CERAMAH",
        "DDS/SAMBANG/KUNJUNGAN",
        "FGD/FSK (FORUM SILATURAHMI KAMTIBMAS)",
        "MOBIL SPM/BINLUHPENMAS/HIMBAUAN",
        "RAKOR K/L/ PEMDA/ INSTANSI",
        "REHAB PENYANDANG SOSIALEKS NAPI",
        "BIN & KATPUAN POKDARKAMTIBMAS KBP3 POLRI",
        "BIN & KATPUAN PENGEMBAN POLMAS",
        "PROBLEM SOLVING",
        "BIN SAKA BHAYANGKARA PKS POCIL KOM.WANITA",
        "PEMBINA UPACARA (SD/SMP/SMA)",
        "BIN & KATPUAN BHABINKAMTIBMAS",
        "PENDAMPINGAN DANA DESA",
        "PEMBUATAN LI BHABINKAMTIBMAS",
        "BINLUH ATURAN PEMOTONGAN HEWAN PRODUKTIF",
        "KEGIATAN KEAGAMAAN",
        "BAKSOS/ BAKKES",
        "KRYD/SATGASNUS",
        "OPS BINA KUSUMA",
        "OPS BINA WASPADA",
        "OPS BINA KARUNA",
        "KORWAS BINTEKNIS SATPAM/POLSUS",
        "DIKLAT/KATPUAN SATPAM/POLSUS",
        "AUDIT BUJP/REKOM BUJP",
        "BIN/KATPUAN KAPOS/SISKAMLING",
        "PPK PROG 5 GIAT 12",
        "PPK PROG 5 GIAT 14",
        "PPK PROG 5 GIAT 21",
        "KERMA",
        "SUPERVISI/ ASISTENSI",
        "OPERASI MANTAP BRATA/PRAJA",
        "OPERASI KEPOL (KETUPAT LILIN)",
        "OPERASI AMAN NUSA (KONTIJENSI)",
        "NEGOSIATOR",
        "GATUR LALIN",
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->kegiatan as $key => $kegiatan) {
            ListKegiatan::updateOrCreate([
                'nama' => $kegiatan
            ], [
                'deskripsi' => null
            ]);
        }
    }
}
