<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignIdIzinToRiwayatSio extends Migration
{
    public function up()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->dropForeign('riwayat_sio_id_izin_foreign');
        });
    }

    public function down()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->foreign('id_izin')
                ->references('id_izin')
                ->on('data_checklist')
                ->onUpdate('cascade');
        });
    }
}
