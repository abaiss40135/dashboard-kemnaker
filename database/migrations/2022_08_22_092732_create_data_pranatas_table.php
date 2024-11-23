<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPranatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('data_pranatas');
        Schema::create('data_pranatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polda');
            $table->string('polres');
            $table->string('nama_pranata');
            $table->string('rw');
            $table->string('dusun');
            $table->string('desa_kel');
            $table->string('kecamatan');
            $table->string('kab_kota');
            $table->string('provinsi');
            $table->string('keterangan');
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
        Schema::dropIfExists('data_pranatas');
    }
}
