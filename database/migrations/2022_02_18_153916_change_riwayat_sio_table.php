<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRiwayatSioTable extends Migration
{
    public function up()
    {
        /*
         * Mengubah length no_izin ke 150 char
         */
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->string('nomor_izin', 150)->change();
        });
    }

    public function down()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->string('nomor_izin', 18)->change();
        });
    }
}
