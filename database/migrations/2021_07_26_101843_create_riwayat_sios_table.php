<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatSiosTable extends Migration
{
    public function up()
    {
        Schema::create('riwayat_sio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_izin', 25);
            $table->foreign('id_izin')
                ->references('id_izin')
                ->on('data_checklist')
                ->onUpdate('cascade');
            $table->foreignId('status_sio_id')->constrained();
            $table->string('polda');
            $table->integer('status_audit')->nullable();
            $table->text('file_hasil_audit')->nullable();
            $table->boolean('validasi_hasil_audit')->nullable();
            $table->text('file_surat_rekom')->nullable();
            $table->boolean('validasi_surat_rekom')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_sio');
    }
}
