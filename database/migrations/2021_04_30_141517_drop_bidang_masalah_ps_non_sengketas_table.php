<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class dropBidangMasalahPsNonSengketasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ps_non_sengketas', function (Blueprint $table) {
            $table->dropColumn('bidang_masalah');
            $table->dropColumn('uraian_kejadian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ps_non_sengketas', function (Blueprint $table) {
            $table->string('bidang_masalah');
            $table->string('uraian_kejadian');
        });
    }
}
