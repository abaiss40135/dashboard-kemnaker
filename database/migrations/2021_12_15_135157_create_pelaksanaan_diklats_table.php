<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaksanaanDiklatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelaksanaan_diklats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polda');
            $table->string('bujp');
            $table->string('tempat');
            $table->time('waktu');
            $table->integer('pria');
            $table->integer('wanita');
            $table->integer('jumlah_peserta');
            $table->date('tanggal_buka');
            $table->date('tanggal_tutup');
            $table->integer('sendiri');
            $table->integer('kerma');
            $table->string('latdik');
            $table->string('keterangan');
            $table->integer('jumlah');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('pelaksanaan_diklats');
    }
}
