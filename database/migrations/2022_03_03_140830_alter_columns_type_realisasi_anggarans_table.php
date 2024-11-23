<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsTypeRealisasiAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('realisasi_anggarans', function (Blueprint $table) {
            $table->bigInteger('pagu_awal')->default(0)->change();
            $table->bigInteger('pagu_revisi')->default(0)->change();
            $table->bigInteger('realisasi_rupiah')->default(0)->change();
            $table->bigInteger('sisa_rupiah')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
