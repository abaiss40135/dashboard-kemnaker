<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTanggalLaporanPubliks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_publiks', function (Blueprint $table) {
            $table->renameColumn('tanggal_dapat_informasi', 'tanggal_mendapatkan_informasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_publiks', function (Blueprint $table) {
            $table->renameColumn('tanggal_dapat_informasi', 'tanggal_mendapatkan_informasi');
        });
    }
}
