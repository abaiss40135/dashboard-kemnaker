<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_uu');
            $table->string('deskripsi_uu');
            $table->string('tanggal_diunggah');
            $table->string('file_uu');
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
        Schema::dropIfExists('uus');
    }
}