<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPendaftaranSiosTableAddSuratRekom extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            $table->text('hasil_audit')->nullable();
            $table->text('surat_rekom')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            $table->dropColumn(['hasil_audit', 'surat_rekom']);
        });
    }
}
