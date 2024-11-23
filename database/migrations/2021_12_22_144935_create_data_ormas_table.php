<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataOrmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_ormas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_kommas');
            $table->string('badan_hukum');
            $table->string('akta_notaris');
            $table->string('pengesahan');
            $table->string('npwp');
            $table->string('duk_pembina');
            $table->string('pengurus');
            $table->string('bergerak');
            $table->string('kebijakan');
            $table->string('jumlah_anggota');
            $table->string('keterangan');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('data_ormas');
    }
}
