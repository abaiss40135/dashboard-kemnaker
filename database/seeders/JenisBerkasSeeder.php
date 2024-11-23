<?php

namespace Database\Seeders;

use App\Models\JenisBerkas;
use Illuminate\Database\Seeder;

class JenisBerkasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $SIO_PUSAT = [
            "cv" => 'Curriculum Vitae',
            "nib" => 'Dokumen NIB Perusahaan',
            "izin_usaha" => 'Dokumen Izin Usaha BUJP',
            "ktp_pemohon" => 'KTP Pemohon/Pemimpin Perusahaan',
            "sertifikat_iso" => 'Sertifikat ISO/SNI',
            "surat_permohonan" => 'Surat Pengantar/Permohonan',
            "bukti_setoran_pnpb" => 'Bukti Setoran PNBP',
            "sertifikat_apjatin" => 'Sertifikat Keanggotaan Asosiasi Perusahaan Jasa Pengolahan Uang Tunai Indonesia (Apjatin)',
            "struktur_organisasi" => 'Struktur Organisasi',
            "izin_lokasi_berusaha" => 'Dokumen Izin Lokasi Berusaha Bujp',
            "keanggotaan_asosiasi" => 'Fotocopy Sertifikat Keanggotaan Asosiasi Bidang Security',
            "surat_keputusan_bank" => 'Surat Keputusan Kepala Departemen Pengelolaan Uang oleh Bank Indonesia',
            "sertifikat_tenaga_ahli" => 'Sertifikat Tenaga Ahli Khusus Bidang Usaha Jasa Konsultasi',
            "izin_komersial_operasional" => 'Dokumen Izin Komersial/Operasional Bujp',
            "konfirmasi_status_wajib_pajak" => 'Konfirmasi Status Wajib Pajak (KSWP)',
            "sertifikat_gada_utama_milik_ceo" => 'Fotocopy Ijazah Gada Utama Milik CEO/Pemilik, Dirut Atau Direktur',
            "surat_pernyataan_bermaterai_non_asing" => 'Surat Pernyataan Bermaterai Tidak Menggunakan Tenaga Asing',
            "surat_pernyataan_bermaterai_berseragam" => 'Surat Pernyataan Bermaterai menggunakan Seragam Satpam',
        ];

        $SIO_CABANG = [
            "sio_kantor_pusat" => 'SIO Kantor Pusat (Aktif)',
            "cv_kantor_cabang" => 'Curriculum Vitae Kantor Cabang',
            "struktur_organisasi_kantor_cabang" => 'Struktur Organisasi Kantor Cabang',
            'sertifikat_gada_utama_milik_ceo_kantor_cabang' => 'Fotocopy Ijazah Gada Utama Milik Kepala Kantor Cabang',
        ];

        foreach (array_merge($SIO_PUSAT, $SIO_CABANG) as $jenis => $keterangan) {
            JenisBerkas::updateOrCreate(['jenis' => $jenis], ['keterangan' => $keterangan]);
        }
    }
}
