<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPendaftaranSiosTable extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            $table->dropColumn([
                'surat_permohonan', 'struktur_organisasi', 'cv', 'konfirmasi_status_wajib_pajak',
                'surat_pernyataan_bermaterai_non_asing', 'surat_pernyataan_bermaterai_berseragam',
                'keanggotaan_asosiasi', 'bukti_setoran_pnpb', 'sertifikat_tenaga_ahli',
                'sertifikat_gada_utama_milik_ceo', 'sertifikat_iso', 'sertifikat_apjatin',
                'surat_keputusan_bank'
            ]);
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            $table->string('surat_permohonan')->nullable();
            $table->string('struktur_organisasi')->nullable();
            $table->string('cv')->nullable();
            $table->string('konfirmasi_status_wajib_pajak')->nullable();
            $table->string('surat_pernyataan_bermaterai_non_asing')->nullable();
            $table->string('surat_pernyataan_bermaterai_berseragam')->nullable();
            $table->string('keanggotaan_asosiasi')->nullable();
            $table->string('bukti_setoran_pnpb')->nullable();
            $table->string('sertifikat_tenaga_ahli')->nullable();
            $table->string('sertifikat_gada_utama_milik_ceo')->nullable();
            $table->string('sertifikat_iso')->nullable();
            $table->string('sertifikat_apjatin')->nullable();
            $table->string('surat_keputusan_bank')->nullable();
        });
    }
}
