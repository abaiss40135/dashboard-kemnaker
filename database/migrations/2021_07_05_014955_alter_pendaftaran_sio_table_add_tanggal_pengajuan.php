<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPendaftaranSioTableAddTanggalPengajuan extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            $table->dateTime('tanggal_pengajuan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pengajuan']);
        });
    }
}
