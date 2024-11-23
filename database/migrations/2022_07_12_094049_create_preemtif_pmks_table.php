<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreemtifPmksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preemtif_pmks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polda');
            $table->string('polres');
            $table->integer('sosialisasi')->default(0);
            $table->integer('pengobatan')->default(0);
            $table->integer('dekontaminasi')->default(0);
            $table->integer('amplifikasi_meme')->default(0);
            $table->string('kode_satuan');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preemtif_pmks');
    }
}
