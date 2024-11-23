<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapPerlengkapansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_perlengkapans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tgl_input_data');
            $table->string('polres');
            $table->integer('r2');
            $table->integer('toa');
            $table->integer('gigaphone');
            $table->integer('rompi_jaket');
            $table->integer('borgol');
            $table->integer('kamera');
            $table->integer('ht');
            $table->integer('tongkat_polri');
            $table->integer('hp');
            $table->string('lain_lain');
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
        Schema::dropIfExists('rekap_perlengkapans');
    }
}
