<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBelumBersertifkasiColumnsToDataSatpamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_satpams', function (Blueprint $table) {
            $table->string('polda')->nullable();
            $table->unsignedInteger('diklat_gp')->change()->nullable();
            $table->unsignedInteger('diklat_gm')->change()->nullable();
            $table->unsignedInteger('diklat_gu')->change()->nullable();
            $table->unsignedInteger('bersertifikasi_gp')->change()->nullable();
            $table->unsignedInteger('bersertifikasi_gm')->change()->nullable();
            $table->unsignedInteger('bersertifikasi_gu')->change()->nullable();
            $table->unsignedInteger('belum_bersertifikasi_gp')->nullable();
            $table->unsignedInteger('belum_bersertifikasi_gm')->nullable();
            $table->unsignedInteger('belum_bersertifikasi_gu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_satpams', function (Blueprint $table) {
            $table->dropColumn('polda');
            $table->unsignedBigInteger('diklat_gp')->change()->nullable();
            $table->unsignedBigInteger('diklat_gm')->change()->nullable();
            $table->unsignedBigInteger('diklat_gu')->change()->nullable();
            $table->unsignedBigInteger('bersertifikasi_gp')->change()->nullable();
            $table->unsignedBigInteger('bersertifikasi_gm')->change()->nullable();
            $table->unsignedBigInteger('bersertifikasi_gu')->change()->nullable();
            $table->dropColumn('belum_bersertifikasi_gp');
            $table->dropColumn('belum_bersertifikasi_gm');
            $table->dropColumn('belum_bersertifikasi_gu');
        });
    }
}
