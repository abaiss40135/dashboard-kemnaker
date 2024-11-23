<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDdsWargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dds_wargas' , function(Blueprint $table){
            $table->text('nama_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('jenis_kelamin_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('tempat_lahir_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('tanggal_lahir_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('agama_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('suku_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('pekerjaan_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('kewarganegaraan_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('detail_alamat_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('provinsi_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('kabupaten_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('kecamatan_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('desa_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('rw_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('rt_kepala_keluarga')->nullable()->default('...')->change();
            $table->text('jumlah_anggota_keluarga_serumah')->nullable()->default('...')->change();
            $table->text('nama_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->text('hubungan')->nullable()->default('...')->change();
            $table->text('no_tel_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->text('detail_alamat_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->text('provinsi_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->text('kabupaten_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->text('kecamatan_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->text('desa_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->text('rw_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->text('rt_keluarga_bukan_serumah')->nullable()->default('...')->change();
            $table->text('tanggal_kunjungan')->nullable()->default('...')->change();
            $table->text('kunjungan_ke')->nullable()->default('...')->change();
            $table->text('nama_penerima_kunjungan')->nullable()->default('...')->change();
            $table->text('foto_kunjungan')->nullable()->default('...')->change();
            $table->text('keterangan')->nullable()->default('...')->change();
            $table->text('jenis_pendapat_warga')->nullable()->default('...')->change();
            $table->text('bidang_pendapat_warga')->nullable()->default('...')->change();
            $table->text('uraian_pendapat_warga' , 2000)->nullable()->default('...')->change();
            $table->text('urgensi')->nullable()->default('...')->change();
            $table->text('keseringan')->nullable()->default('...')->change();
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
