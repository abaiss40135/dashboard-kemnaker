<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataStokOpnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_stok_opnames', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bulan');
            $table->integer('kta_gp_guna');
            $table->integer('kta_gp_rusak');
            $table->integer('kta_gp_jumlah');
            $table->integer('kta_gp_sisa');
            $table->integer('kta_gp_no_blangko');
            $table->integer('kta_gm_guna');
            $table->integer('kta_gm_rusak');
            $table->integer('kta_gm_jumlah');
            $table->integer('kta_gm_sisa');
            $table->integer('kta_gm_no_blangko');
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
        Schema::dropIfExists('data_stok_opnames');
    }
}
