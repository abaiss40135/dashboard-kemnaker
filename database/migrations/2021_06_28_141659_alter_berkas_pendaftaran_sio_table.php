<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBerkasPendaftaranSioTable extends Migration
{
    public function up()
    {
        Schema::table('berkas_pendaftaran_sio', function (Blueprint $table) {
            $table->boolean('validasi')->nullable(true)->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('berkas_pendaftaran_sio', function (Blueprint $table) {
            $table->boolean('validasi')->nullable(false)->default(false)->change();
        });
    }
}
