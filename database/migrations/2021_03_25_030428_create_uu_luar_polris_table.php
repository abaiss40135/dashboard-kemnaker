<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUuLuarPolrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uu_luar_polris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_uu');
            $table->string('deskripsi_uu')->nullable();
            $table->string('file_uu');
            $table->string('tanggal_diunggah');
            $table->integer('notification')->nullable();
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
        Schema::dropIfExists('uu_luar_polris');
    }
}