<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogStatusRiwayatSioTable extends Migration
{
    public function up()
    {
        Schema::create('log_status_riwayat_sio', function (Blueprint $table) {
            $table->unsignedBigInteger('riwayat_sio_id');
            $table->foreign('riwayat_sio_id')
                ->references('id')
                ->on('riwayat_sio');
            $table->foreignId('status_sio_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_status_riwayat_sio');
    }
}
