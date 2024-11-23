<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsToFloatSerapanAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serapan_anggarans', function (Blueprint $table) {
            $table->float('presentase')->default(0)->change();
            $table->float('pnbp_presentase')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serapan_anggarans', function (Blueprint $table) {
            $table->integer('presentase')->default(0)->change();
            $table->integer('pnbp_presentase')->default(0)->change();
        });
    }
}
