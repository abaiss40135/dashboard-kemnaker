<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnUraianFromLaporanPubliksTable extends Migration
{
    public function up()
    {
        Schema::table('laporan_publiks', function (Blueprint $table) {
            $table->dropColumn('uraian');
        });
    }

    public function down()
    {
        Schema::table('laporan_publiks', function (Blueprint $table) {
            $table->text('uraian')->nullable();
        });
    }
}
