<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDdsWargaTableChangeDateColumn extends Migration
{
    public function up()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->dropColumn('tanggal_kunjungan');
        });

        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->date('tanggal_kunjungan')->nullable();
            $table->string('satuan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->string('tanggal_kunjungan')->change();
            $table->dropColumn('satuan');
        });
    }
}
