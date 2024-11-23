<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSatpamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satpams', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->string('nama');
            $table->string('no_ktp');
            $table->string('no_kta');
            $table->string('jenis_kelamin');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('detail_alamat');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('rt');
            $table->string('rw');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('agama');
            $table->string('no_hp');
            $table->unsignedBigInteger('bujp_id');
            $table->string('tempat_tugas');
            $table->string('tanggal_terbit_kta');
            $table->string('foto_kta');
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
        Schema::dropIfExists('satpams');
    }
}
