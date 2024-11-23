<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnKeteranganToRiwayatSioTable extends Migration
{
    public function up()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->text('penilaian_audit')->nullable();
            $table->text('keterangan_validasi_hasil_audit')->nullable();
            $table->text('keterangan_validasi_surat_rekom')->nullable();
        });
    }

    public function down()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->dropColumn(['penilaian_audit', 'keterangan_validasi_hasil_audit', 'keterangan_validasi_surat_rekom']);
        });
    }
}
