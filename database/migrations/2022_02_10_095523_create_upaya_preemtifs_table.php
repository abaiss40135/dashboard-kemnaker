<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpayaPreemtifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upaya_preemtifs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kesatuan');
            $table->string('bulan');
            $table->string('masalah_sosial')->nullable();
            $table->string('dds')->nullable();
            $table->string('penyuluhan')->nullable();
            $table->string('sambang')->nullable();
            $table->string('mobil_penling')->nullable();
            $table->string('sosialisasi')->nullable();
            $table->string('lain_lain')->nullable();
            $table->integer('jumlah')->default(0);
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('upaya_preemtifs');
    }
}
