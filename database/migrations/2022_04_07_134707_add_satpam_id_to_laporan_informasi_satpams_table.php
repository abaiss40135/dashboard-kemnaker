<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSatpamIdToLaporanInformasiSatpamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_informasi_satpams', function (Blueprint $table) {
            $table->unsignedBigInteger('satpam_id')->nullable();
            $table->foreign('satpam_id')->references('id')->on('satpams')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_informasi_satpams', function (Blueprint $table) {
            $table->dropForeign(['satpam_id']);
            $table->dropColumn('satpam_id');
        });
    }
}
