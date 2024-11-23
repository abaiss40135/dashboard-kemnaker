<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapharPelatihanFabasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laphar_pelatihan_fabas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polda');
            $table->string('lokasi_pelatihan');
            $table->string('nama_trainer');
            $table->string('jumlah_peserta');
            $table->string('kode_satuan');
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
        Schema::dropIfExists('laphar_pelatihan_fabas');
    }
}
