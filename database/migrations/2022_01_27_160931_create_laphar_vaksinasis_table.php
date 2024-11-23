<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapharVaksinasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laphar_vaksinasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kab_kota');
            $table->string('vaksinasi_sdm_kesehatan');
            $table->integer('sdm_kesehatan_divaksin_cov1');
            $table->string('sdm_kesehatan_vaksin_cov1');
            $table->integer('sdm_kesehatan_divaksin_cov2');
            $table->string('sdm_kesehatan_vaksin_cov2');
            $table->integer('sdm_kesehatan_divaksin_cov3');
            $table->string('sdm_kesehatan_vaksin_cov3');
            $table->integer('vaksinasi_lansia_divaksin_cov1');
            $table->string('vaksinasi_lansia_vaksin_cov1');
            $table->integer('vaksinasi_lansia_divaksin_cov2');
            $table->string('vaksinasi_lansia_vaksin_cov2');
            $table->integer('vaksinasi_yanpublik_divaksin_cov1');
            $table->string('vaksinasi_yanpublik_vaksin_cov1');
            $table->integer('vaksinasi_yanpublik_divaksin_cov2');
            $table->string('vaksinasi_yanpublik_vaksin_cov2');
            $table->integer('mu_divaksin_cov1');
            $table->string('mu_vaksin_cov1');
            $table->integer('mu_divaksin_cov2');
            $table->string('mu_vaksin_cov2');
            $table->integer('remaja_divaksin_cov1');
            $table->string('remaja_vaksin_cov1');
            $table->integer('remaja_divaksin_cov2');
            $table->string('remaja_vaksin_cov2');
            $table->integer('gr_divaksin_cov1');
            $table->string('gr_vaksin_cov1');
            $table->integer('gr_divaksin_cov2');
            $table->string('gr_vaksin_cov2');
            $table->integer('jumlah');
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
        Schema::dropIfExists('laphar_vaksinasis');
    }
}
