<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataGiatKorwasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_giat_korwas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('instansi');
            $table->date('waktu');
            $table->string('tempat');
            $table->string('kegiatan');
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
        Schema::dropIfExists('data_giat_korwas');
    }
}
