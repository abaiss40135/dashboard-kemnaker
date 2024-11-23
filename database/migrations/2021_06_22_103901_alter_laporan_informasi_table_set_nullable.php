<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLaporanInformasiTableSetNullable extends Migration
{
    public function up()
    {
        Schema::table('laporan_informasi', function (Blueprint $table) {
            $table->string('nilai_abjad')->nullable()->default(null)->change();
            $table->string('bidang')->nullable(false)->default(null)->change();
            $table->text('uraian')->nullable()->default(null)->change();
            $table->string('form_type')->nullable(false)->default(null)->change();
            $table->unsignedBigInteger('form_id')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('laporan_informasi', function (Blueprint $table) {
            //
        });
    }
}
