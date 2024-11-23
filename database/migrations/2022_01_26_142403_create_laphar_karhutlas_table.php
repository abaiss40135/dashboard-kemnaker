<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapharKarhutlasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laphar_karhutlas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polres');
            $table->string('himbauan');
            $table->string('fgd');
            $table->string('maklumat_kapolda');
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
        Schema::dropIfExists('laphar_karhutlas');
    }
}
