<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranSiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran_sios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bujp_id');
            $table->foreign('bujp_id')->references('id')->on('bujps')->onDelete('cascade');
            $table->string('surat_permohonan');
            $table->string('struktur_organisasi');
            $table->string('daftar_riwayat_hidup_pimpinan');
            $table->string('konfirmasi_status_wajib_pajak');
            $table->string('surat_pernyataan_bermaterai_non_asing');
            $table->string('surat_pernyataan_bermaterai_berseragam');
            $table->string('keanggotaan_asosiasi');
            $table->string('surat_izin_operasional');
            $table->string('surat_rekom_polda');
            $table->string('sertifikat_tenaga_ahli');
            $table->string('sertifikat_gada_utama_milik_ceo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran_sios');
    }
}
