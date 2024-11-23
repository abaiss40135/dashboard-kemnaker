<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapharPcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laphar_pcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('satker');
            $table->integer('perbelanjaan');
            $table->integer('perkantoran');
            $table->integer('pemukiman');
            $table->integer('kawasan');
            $table->integer('transportasi_publik');
            $table->integer('tempat_wisata');
            $table->integer('komunitas_hobi');
            $table->integer('jumlah_komunitas');
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
        Schema::dropIfExists('laphar_pcs');
    }
}
