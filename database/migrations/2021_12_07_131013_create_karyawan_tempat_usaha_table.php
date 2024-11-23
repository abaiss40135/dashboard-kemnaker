<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTempatUsahaTable extends Migration
{
    public function up()
    {
        Schema::create('karyawan_tempat_usaha', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('dds_tempat_usaha_id');
            $table->string('nama');
            $table->string('jenis_kelamin', 9);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jabatan');
            $table->string('no_hp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('karyawan_tempat_usaha');
    }
}
