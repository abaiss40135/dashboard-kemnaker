<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPolsusKorwasbintekTablesAddKodeSatuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kegiatan_korwasbintek_koordinasis', function (Blueprint $table) {
            $table->string('kode_satuan')->nullable();
        });
        Schema::table('kegiatan_korwasbintek_pengawasans', function (Blueprint $table) {
            $table->string('kode_satuan')->nullable();
        });
        Schema::table('kegiatan_korwasbintek_pembinaan_teknis', function (Blueprint $table) {
            $table->string('kode_satuan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kegiatan_korwasbintek_koordinasis', function (Blueprint $table) {
            $table->dropColumn('kode_satuan');
        });
        Schema::table('kegiatan_korwasbintek_pengawasans', function (Blueprint $table) {
            $table->dropColumn('kode_satuan');
        });
        Schema::table('kegiatan_korwasbintek_pembinaan_teknis', function (Blueprint $table) {
            $table->dropColumn('kode_satuan');
        });
    }
}
