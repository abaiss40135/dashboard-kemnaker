<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_dais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_dai');
            $table->string('perorangan_kelompok');
            $table->string('no_hp');
            $table->string('rt_rw');
            $table->string('desa_kel');
            $table->string('kecamatan');
            $table->string('kab_kota');
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
        Schema::dropIfExists('data_dais');
    }
}
