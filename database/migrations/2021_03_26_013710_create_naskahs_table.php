<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNaskahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('naskahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_naskah');
            $table->string('deskripsi_naskah')->nullable();
            $table->string('tanggal_diunggah');
            $table->string('file_naskah');
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
        Schema::dropIfExists('naskahs');
    }
}