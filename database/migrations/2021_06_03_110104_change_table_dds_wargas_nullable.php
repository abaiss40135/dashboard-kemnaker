<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableDdsWargasNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dds_wargas' , function(Blueprint $table){
            $table->string('nama_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('jenis_kelamin_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('tempat_lahir_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('tanggal_lahir_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('agama_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('suku_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('pekerjaan_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('kewarganegaraan_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('detail_alamat_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('provinsi_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('kabupaten_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('kecamatan_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('desa_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('rw_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('rt_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('jumlah_anggota_keluarga_serumah')->nullable()->default('...')->change();
            $table->string('nama_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->string('hubungan')->nullable()->default('...')->change();
            $table->string('no_tel_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->string('detail_alamat_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->string('provinsi_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->string('kabupaten_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->string('kecamatan_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->string('desa_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->string('rw_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->string('rt_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->string('tanggal_kunjungan')->nullable()->default('...')->change();
            $table->string('kunjungan_ke')->nullable()->default('...')->change();
            $table->string('nama_penerima_kunjungan')->nullable()->default('...')->change();
            $table->string('foto_kunjungan')->nullable()->default('...')->change();
            $table->string('keterangan')->nullable()->default('...')->change();
            $table->string('jenis_pendapat_warga')->nullable()->default('...')->change();
            $table->string('bidang_pendapat_warga')->nullable()->default('...')->change();
            $table->string('uraian_pendapat_warga' , 2000)->nullable()->default('...')->change();
            $table->string('urgensi')->nullable()->default('...')->change();
            $table->string('keseringan')->nullable()->default('...')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
