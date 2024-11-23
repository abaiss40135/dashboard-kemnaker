<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDdsWargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dds_wargas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nama_kepala_keluarga');
            $table->string('jenis_kelamin_kepala_keluarga');
            $table->string('tempat_lahir_kepala_keluarga');
            $table->string('tanggal_lahir_kepala_keluarga');
            $table->string('agama_kepala_keluarga');
            $table->string('suku_kepala_keluarga');
            $table->string('no_tel_kepala_keluarga')->nullable();
            $table->string('pekerjaan_kepala_keluarga');
            $table->string('kewarganegaraan_kepala_keluarga');
            $table->string('detail_alamat_kepala_keluarga');
            $table->string('provinsi_kepala_keluarga');
            $table->string('kabupaten_kepala_keluarga');
            $table->string('kecamatan_kepala_keluarga');
            $table->string('desa_kepala_keluarga');
            $table->string('rw_kepala_keluarga');
            $table->string('rt_kepala_keluarga');
            $table->string('jumlah_anggota_keluarga_serumah');
            $table->string('nama_keluarga_bukan_serumah');
            $table->string('hubungan');
            $table->string('no_tel_keluarga_bukan_serumah')->nullable();
            $table->string('detail_alamat_keluarga_bukan_serumah');
            $table->string('provinsi_keluarga_bukan_serumah');
            $table->string('kabupaten_keluarga_bukan_serumah');
            $table->string('kecamatan_keluarga_bukan_serumah');
            $table->string('desa_keluarga_bukan_serumah');
            $table->string('rw_keluarga_bukan_serumah');
            $table->string('rt_keluarga_bukan_serumah');
            $table->string('tanggal_kunjungan');
            $table->string('kunjungan_ke');
            $table->string('nama_penerima_kunjungan');
            $table->string('foto_kunjungan');
            $table->string('keterangan');
            $table->string('jenis_pendapat_warga');
            $table->string('keyword');
            $table->string('bidang_pendapat_warga');
            $table->string('uraian_pendapat_warga' , 2000);
            $table->string('urgensi');
            $table->string('keseringan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dds_wargas');
    }
}
