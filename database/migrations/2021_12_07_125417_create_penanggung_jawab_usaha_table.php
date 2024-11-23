<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenanggungJawabUsahaTable extends Migration
{
    public function up()
    {
        Schema::create('penanggung_jawab_usaha', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('dds_tempat_usaha_id');
            $table->string('nama');
            $table->string('jenis_kelamin', 9);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('type', 10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penanggung_jawab_usaha');
    }
}
