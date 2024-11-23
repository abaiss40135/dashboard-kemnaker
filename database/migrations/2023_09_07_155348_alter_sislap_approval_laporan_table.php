<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSislapApprovalLaporanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sislap_approval_laporan', function (Blueprint $table) {
            $table->string('level', 13)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sislap_approval_laporan', function (Blueprint $table) {
            $table->string('level', 6)->change();
        });
    }
}
