<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnKeteranganToBerkasPendaftaranSio extends Migration
{
    public function up()
    {
        Schema::table('berkas_pendaftaran_sio', function (Blueprint $table) {
            $table->text('keterangan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('berkas_pendaftaran_sio', function (Blueprint $table) {
            $table->dropColumn(['keterangan']);
        });
    }
}
