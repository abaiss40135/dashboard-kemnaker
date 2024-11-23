<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalSioOnTenagaPengamanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenaga_pengamanans', function (Blueprint $table) {
            $table->date('tanggal_sio')->after('no_sio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenaga_pengamanans', function (Blueprint $table) {
            $table->dropColumn('tanggal_sio');
        });
    }
}
