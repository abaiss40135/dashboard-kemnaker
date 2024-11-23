<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeSatuanIndexToLaporanBhabinkamtibmasTable extends Migration
{
    public function up()
    {
        Schema::table('laporan_bhabinkamtibmas', function (Blueprint $table) {
            $table->index('kode_satuan');
        });
    }

    public function down()
    {
        Schema::table('laporan_bhabinkamtibmas', function (Blueprint $table) {
            $table->dropIndex(['kode_satuan']);
        });
    }
}
