<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeteksiDinisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deteksi_dinis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama_narasumber');
            $table->string('pekerjaan');
            $table->string('detail_alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->date('tanggal_mendapatkan_informasi');
            $table->string('jam_mendapatkan_informasi');
            $table->string('lokasi_mendapatkan_informasi');
            $table->string('metode_mendapatkan_informasi');
            $table->string('bidang_informasi');
            $table->string('keyword');
            $table->text('uraian_informasi');
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
        Schema::dropIfExists('deteksi_dinis');
    }
}