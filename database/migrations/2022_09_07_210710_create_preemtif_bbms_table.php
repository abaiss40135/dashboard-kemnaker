<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreemtifBbmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preemtif_bbms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polda');
            $table->string('polres');
            $table->string('jenis_giat_preemtif');
            $table->string('jml_masyarakat_dilibatkan');
            $table->string('kode_satuan');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('preemtif_bbms');
    }
}
