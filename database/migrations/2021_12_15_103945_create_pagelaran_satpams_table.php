<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagelaranSatpamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagelaran_satpams', function (Blueprint $table) {
            $table->id('id');
            $table->string('jenis_perusahaan');
            $table->integer('pria');
            $table->integer('wanita');
            $table->integer('jumlah');
            $table->integer('gada_pratama');
            $table->integer('gada_madya');
            $table->integer('gada_utama');
            $table->integer('belum');
            $table->integer('outsourcing');
            $table->integer('organik');
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
        Schema::dropIfExists('pagelaran_satpams');
    }
}
