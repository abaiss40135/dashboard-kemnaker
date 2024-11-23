<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsTypeSerapanAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serapan_anggarans', function (Blueprint $table) {
            $table->integer('pagu')->default(0)->change();
            $table->integer('realisasi')->default(0)->change();
            $table->integer('sisa')->default(0)->change();
            $table->integer('pnbp_pagu')->default(0)->change();
            $table->integer('pnbp_realisasi')->default(0)->change();
            $table->integer('pnbp_sisa')->default(0)->change();
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
