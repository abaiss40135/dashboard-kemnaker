<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLokasiPenugasansTable extends Migration
{
    public function up()
    {
        Schema::create('lokasi_penugasans', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->char('provinsi_code');
            $table->foreign('provinsi_code')
                ->references('code')
                ->on('provinces')
                ->onUpdate('cascade');

            $table->char('kota_code');
            $table->foreign('kota_code')
                ->references('code')
                ->on('cities')
                ->onUpdate('cascade');

            $table->char('kecamatan_code');
            $table->foreign('kecamatan_code')
                ->references('code')
                ->on('districts')
                ->onUpdate('cascade');

            $table->char('desa_code');
            $table->foreign('desa_code')
                ->references('code')
                ->on('villages')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lokasi_penugasans');
    }
}
