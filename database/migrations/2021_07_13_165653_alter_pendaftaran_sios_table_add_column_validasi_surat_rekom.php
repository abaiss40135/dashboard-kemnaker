<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPendaftaranSiosTableAddColumnValidasiSuratRekom extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            $table->boolean('validasi_hasil_audit')->nullable();
            $table->boolean('validasi_surat_rekom')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            $table->dropColumn(['validasi_hasil_audit', 'validasi_surat_rekom']);
        });
    }
}
