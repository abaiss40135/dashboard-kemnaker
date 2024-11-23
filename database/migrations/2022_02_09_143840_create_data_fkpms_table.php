<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataFkpmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_fkpms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_fkpm');
            $table->string('nama_anggota_fkpm');
            $table->string('model_kawasan');
            $table->string('model_wilayah');
            $table->string('bkpm');
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
        Schema::dropIfExists('data_fkpms');
    }
}
