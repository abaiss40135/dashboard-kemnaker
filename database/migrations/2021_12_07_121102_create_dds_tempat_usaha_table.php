<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDdsTempatUsahaTable extends Migration
{
    public function up()
    {
        Schema::create('dds_tempat_usaha', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_tempat_usaha');
            $table->string('jenis_usaha');
            $table->time('jam_kerja_awal');
            $table->time('jam_kerja_akhir');
            $table->text('alamat_tempat_usaha');
            $table->string('no_telp_tempat_usaha');
            $table->text('cara_komunikasi_darurat');
            $table->double('jumlah_karyawan');
            $table->boolean('is_asrama')->default(false);
            $table->text('catatan');
            $table->string('nama_penerima_kunjungan');
            $table->date('tanggal_kunjungan');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dds_tempat_usaha');
    }
}
