<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDiklatPolsusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('data_diklat_polsuses');

        Schema::create('data_diklat_polsuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polda');
            $table->string('instansi');
            $table->string('tempat');
            $table->string('nama_diklat');
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
        Schema::dropIfExists('data_diklat_polsuses');
    }
}
