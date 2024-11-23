<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsToFloatRealisasiAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('realisasi_anggarans', function (Blueprint $table) {
            $table->float('realisasi_persen')->default(0)->change();
            $table->float('sisa_persen')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('realisasi_anggarans', function (Blueprint $table) {
            $table->integer('realisasi_persen')->default(0)->change();
            $table->integer('sisa_persen')->default(0)->change();
        });
    }
}
