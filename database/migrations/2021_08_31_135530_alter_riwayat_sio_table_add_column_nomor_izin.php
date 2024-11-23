<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRiwayatSioTableAddColumnNomorIzin extends Migration
{
    public function up()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->string('nomor_izin', 18)->nullable();
        });
    }

    public function down()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->dropColumn(['nomor_izin']);
        });
    }
}
