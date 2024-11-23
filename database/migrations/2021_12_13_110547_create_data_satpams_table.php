<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSatpamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_satpams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('diklat_gp')->nullable();
            $table->unsignedBigInteger('diklat_gm')->nullable();
            $table->unsignedBigInteger('diklat_gu')->nullable();
            $table->unsignedBigInteger('bersertifikasi_gp')->nullable();
            $table->unsignedBigInteger('bersertifikasi_gm')->nullable();
            $table->unsignedBigInteger('bersertifikasi_gu')->nullable();
            $table->string('keterangan', 100)->nullable();
            $table->unsignedBigInteger('user_id',)->nullable();
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
        Schema::dropIfExists('data_satpams');
    }
}
