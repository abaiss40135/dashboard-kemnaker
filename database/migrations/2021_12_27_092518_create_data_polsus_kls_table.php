<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPolsusKlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_polsus_kls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kementerian');
            $table->string('nama');
            $table->string('pangkat');
            $table->string('nip');
            $table->string('golongan');
            $table->string('ttl');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('jabatan');
            $table->string('wilayah_penugasan');
            $table->string('dik_umum');
            $table->string('tuk');
            $table->string('bang');
            $table->string('pim');
            $table->string('keterangan');
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
        Schema::dropIfExists('data_polsus_kls');
    }
}
