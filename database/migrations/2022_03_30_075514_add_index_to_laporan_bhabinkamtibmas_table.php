<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToLaporanBhabinkamtibmasTable extends Migration
{
    public function up()
    {
        Schema::table('laporan_bhabinkamtibmas', function (Blueprint $table) {
            $table->index('tags');
            $table->index(['polda', 'nrp', 'kode_satuan']);
            $table->index(['created_at', 'updated_at']);
        });
    }

    public function down()
    {
        Schema::table('laporan_bhabinkamtibmas', function (Blueprint $table) {
            $table->dropIndex(['tags']);
            $table->dropIndex(['polda', 'nrp', 'kode_satuan']);
            $table->dropIndex(['created_at', 'updated_at']);
        });
    }
}
