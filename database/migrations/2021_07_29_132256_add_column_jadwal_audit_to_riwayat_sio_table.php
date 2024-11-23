<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnJadwalAuditToRiwayatSioTable extends Migration
{
    public function up()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->dateTime('jadwal_audit')->nullable();
        });
    }

    public function down()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->dropColumn('jadwal_audit');
        });
    }
}
