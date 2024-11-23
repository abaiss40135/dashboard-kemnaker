<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapPenghargaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_penghargaans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('polres');
            $table->string('kapolri');
            $table->string('kabaharkam');
            $table->string('kakorbinmas');
            $table->string('kapolda');
            $table->string('dirbinmas');
            $table->string('kapolres');
            $table->string('kapolsek');
            $table->string('instansi');
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
        Schema::dropIfExists('rekap_penghargaans');
    }
}
