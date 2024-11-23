<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLaporanPubliksRenameColumn extends Migration
{
    public function up()
    {
        Schema::table('laporan_publiks', function (Blueprint $table) {
            $table->renameColumn('tanggal_mendapatkan_informasi', 'tanggal');
        });
    }

    public function down()
    {
        Schema::table('laporan_publiks', function (Blueprint $table) {
            $table->renameColumn('tanggal', 'tanggal_mendapatkan_informasi');
        });
    }
}
