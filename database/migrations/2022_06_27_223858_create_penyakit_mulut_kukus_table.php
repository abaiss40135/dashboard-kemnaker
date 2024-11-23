<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenyakitMulutKukusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penyakit_mulut_kukus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kandang_sapi')->default(0);
            $table->integer('kandang_kerbau')->default(0);
            $table->integer('kandang_kambing')->default(0);
            $table->integer('kandang_babi')->default(0);
            $table->integer('hewan_sapi')->default(0);
            $table->integer('hewan_kerbau')->default(0);
            $table->integer('hewan_kambing')->default(0);
            $table->integer('hewan_babi')->default(0);
            $table->integer('terinfeksi_sapi')->default(0);
            $table->integer('terinfeksi_kerbau')->default(0);
            $table->integer('terinfeksi_kambing')->default(0);
            $table->integer('terinfeksi_babi')->default(0);
            $table->integer('vaksin_sapi')->default(0);
            $table->integer('vaksin_kerbau')->default(0);
            $table->integer('vaksin_kambing')->default(0);
            $table->integer('vaksin_babi')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->string('kode_satuan');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penyakit_mulut_kukus');
    }
}
