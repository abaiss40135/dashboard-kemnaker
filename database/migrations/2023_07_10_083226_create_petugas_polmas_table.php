<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetugasPolmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petugas_polmas', function (Blueprint $table) {
            $table->id();
            $table->string('polda');
            $table->string('polres');
            $table->integer('jumlah_rw');
            $table->integer('jumlah_petugas_kawasan');
            $table->integer('jumlah_petugas_wilayah');
            $table->string('lampiran_file');
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
        Schema::dropIfExists('petugas_polmas');
    }
}
