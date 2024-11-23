<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTanggalPengajuanToRiwayatSio extends Migration
{
    public function up()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->dateTime('tanggal_pengajuan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pengajuan']);
        });
    }
}
