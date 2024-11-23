<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLaporanBhabinkamtibmasTableAddIndex extends Migration
{
    public function up()
    {
        Schema::table('laporan_bhabinkamtibmas', function (Blueprint $table) {
            $table->index('form_id');
            $table->index('form_type');
            $table->index('bidang');
        });
    }

    public function down()
    {
        Schema::table('laporan_bhabinkamtibmas', function (Blueprint $table) {
            $table->dropIndex(['form_id']);
            $table->dropIndex(['form_type']);
            $table->dropIndex(['bidang']);
        });
    }
}
