<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataBujpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_bujps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_perusahaan');
            $table->integer('konsultasi_aktif');
            $table->integer('konsultasi_tidak_aktif');
            $table->integer('penerapan_aktif');
            $table->integer('penerapan_tidak_aktif');
            $table->integer('pelatihan_aktif');
            $table->integer('pelatihan_tidak_aktif');
            $table->integer('penyediaan_aktif');
            $table->integer('penyediaan_tidak_aktif');
            $table->integer('jasa_aktif');
            $table->integer('jasa_tidak_aktif');
            $table->integer('kawal_aktif');
            $table->integer('kawal_tidak_aktif');
            $table->string('perluasan');
            $table->integer('total');
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
        Schema::dropIfExists('data_bujps');
    }
}
