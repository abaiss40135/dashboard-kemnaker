<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSatpamsTableAddMasaBerlakuKta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('satpams', function (Blueprint $table) {
            $table->date('masa_berlaku_kta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('satpams', function (Blueprint $table) {
            $table->dropColumn('masa_berlaku_kta');
        });
    }
}
