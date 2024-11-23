<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLaporanRemoveColumnKeyword extends Migration
{
    public function up()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->dropColumn('keyword');
        });
        Schema::table('deteksi_dinis', function (Blueprint $table) {
            $table->dropColumn('keyword');
        });
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->dropColumn('keyword');
        });
        Schema::table('ps_eksekutifs', function (Blueprint $table) {
            $table->dropColumn('keyword');
        });
        Schema::table('ps_non_sengketas', function (Blueprint $table) {
            $table->dropColumn('keyword');
        });
    }

    public function down()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->string('keyword');
        });
        Schema::table('deteksi_dinis', function (Blueprint $table) {
            $table->string('keyword');
        });
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->string('keyword');
        });
        Schema::table('ps_eksekutifs', function (Blueprint $table) {
            $table->string('keyword');
        });
        Schema::table('ps_non_sengketas', function (Blueprint $table) {
            $table->string('keyword');
        });
    }
}
