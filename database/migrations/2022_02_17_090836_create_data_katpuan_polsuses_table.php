<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKatpuanPolsusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_katpuan_polsuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polda');
            $table->string('instansi');
            $table->string('tempat');
            $table->string('katpuan');
            $table->string('pria');
            $table->string('wanita');
            $table->string('jumlah');
            $table->date('tgl_buka');
            $table->date('tgl_tutup');
            $table->string('lama_hari');
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
        Schema::dropIfExists('data_katpuan_polsuses');
    }
}
