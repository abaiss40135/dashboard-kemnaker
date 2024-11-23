<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSatkamlingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_satkamlings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kesatuan');
            $table->integer('jml_poskamling');
            $table->integer('aktif');
            $table->integer('pasif');
            $table->string('ketua_pelaksana');
            $table->string('pelaksana');
            $table->integer('jml_pecalang');
            $table->integer('jml_pokdarkamtibmas');
            $table->integer('jml_siswa');
            $table->integer('jml_mahasiswa');
            $table->integer('user_id');
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
        Schema::dropIfExists('data_satkamlings');
    }
}
