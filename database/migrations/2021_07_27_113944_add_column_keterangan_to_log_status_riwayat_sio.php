<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnKeteranganToLogStatusRiwayatSio extends Migration
{
    public function up()
    {
        Schema::table('log_status_riwayat_sio', function (Blueprint $table) {
            $table->text('keterangan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('log_status_riwayat_sio', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
}
