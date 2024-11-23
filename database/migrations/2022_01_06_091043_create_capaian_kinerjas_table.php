<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapaianKinerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capaian_kinerjas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sasaran');
            $table->string('indikator');
            $table->string('target');
            $table->string('realisasi');
            $table->string('kegiatan');
            $table->string('hasil');
            $table->string('hambatan')->nullable();
            $table->string('solusi_hambatan')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('triwulan');
            $table->integer('tahun');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('kode_satuan');
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
        Schema::dropIfExists('capaian_kinerjas');
    }
}
