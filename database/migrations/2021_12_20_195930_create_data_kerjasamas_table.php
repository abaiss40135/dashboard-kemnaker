<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKerjasamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kerjasamas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kementerian_lembaga');
            $table->string('nota_kesepahaman');
            $table->string('perjanjian_kerjasama');
            $table->string('pedoman_kerja');
            $table->string('standar_operasional');
            $table->string('no_tgl');
            $table->string('masa_berlaku');
            $table->string('tentang_judul');
            $table->string('ruang_lingkup');
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
        Schema::dropIfExists('data_kerjasamas');
    }
}
