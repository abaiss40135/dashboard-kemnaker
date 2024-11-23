<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapharMinyakGorengsTable extends Migration
{
    public function up()
    {
        Schema::create('laphar_minyak_gorengs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_daerah');
            $table->string('kab_kota');
            $table->string('kelurahan');
            $table->string('nama_pasar');
            $table->string('alamat_pasar', 300);
            $table->string('ketersediaan');
            $table->string('kebutuhan');
            $table->string('pola_pengiriman');
            $table->integer('harga_tertinggi');
            $table->integer('harga_terendah');
            $table->integer('harga_rerata');
            $table->unsignedBigInteger('user_id');
            $table->string('kode_satuan');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laphar_minyak_gorengs');
    }
}
