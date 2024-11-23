<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterIntegerToBigIntegerSerapanAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serapan_anggarans', function (Blueprint $table) {
            $table->bigInteger('pagu')->default(0)->change();
            $table->bigInteger('realisasi')->default(0)->change();
            $table->bigInteger('sisa')->default(0)->change();
            $table->bigInteger('pnbp_pagu')->default(0)->change();
            $table->bigInteger('pnbp_realisasi')->default(0)->change();
            $table->bigInteger('pnbp_sisa')->default(0)->change();
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
