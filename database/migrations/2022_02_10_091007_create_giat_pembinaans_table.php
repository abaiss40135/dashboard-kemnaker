<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiatPembinaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giat_pembinaans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kesatuan');
            $table->string('bulan');
            $table->string('bencana_dan_pembinaan');
            $table->string('penyuluhan')->nullable();
            $table->string('sambang')->nullable();
            $table->string('sosialisasi')->nullable();
            $table->string('upacara')->nullable();
            $table->string('polisi_cilik')->nullable();
            $table->string('olahraga')->nullable();
            $table->string('baksos')->nullable();
            $table->string('trauma_healing')->nullable();
            $table->string('evakuasi')->nullable();
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
        Schema::dropIfExists('giat_pembinaans');
    }
}
