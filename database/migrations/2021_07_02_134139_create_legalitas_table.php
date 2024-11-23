<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legalitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nib_id');
            $table->foreign('nib_id')
                ->references('id')
                ->on('nomor_induk_berusaha')
                ->onDelete('cascade');

            $table->string('jenis_legal', 2)->nullable();
            $table->string('no_legal',100)->nullable();
            $table->date('tgl_legal')->nullable();
            $table->string('alamat_notaris', 255)->nullable();
            $table->string('nama_notaris', 100)->nullable();
            $table->string('telepon_notaris', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legalitas');
    }
}
