<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnPendaftaranSioIdToBerkasPendaftaranSio extends Migration
{
    public function up()
    {
        Schema::table('berkas_pendaftaran_sio', function (Blueprint $table) {
            $table->dropForeign('berkas_pendaftaran_sio_pendaftaran_sio_id_foreign');
            $table->renameColumn('pendaftaran_sio_id', 'riwayat_sio_id');
            $table->foreign('riwayat_sio_id')
                ->references('id')
                ->on('riwayat_sio')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('berkas_pendaftaran_sio', function (Blueprint $table) {
            $table->dropForeign('berkas_pendaftaran_sio_riwayat_sio_id_foreign');
            $table->renameColumn('riwayat_sio_id', 'pendaftaran_sio_id');
            $table->foreign('pendaftaran_sio_id')
                ->references('id')
                ->on('pendaftaran_sio')
                ->onDelete('cascade');
        });
    }
}
