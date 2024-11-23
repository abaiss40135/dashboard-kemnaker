<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapKegiatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_kegiatans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polres');
            $table->string('dds');
            $table->string('li');
            $table->string('sosial');
            $table->string('dana_perdata');
            $table->string('fisik');
            $table->string('non_fisik');
            $table->string('pendampingan_danadesa');
            $table->string('binluh_narkoba');
            $table->string('pengendalian_pemotonganruminansia');
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
        Schema::dropIfExists('rekap_kegiatans');
    }
}
