<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormIdAndFormTypeIndexToLaporanInformasi extends Migration
{
    public function up()
    {
        Schema::table('laporan_informasi', function (Blueprint $table) {
            $table->index(['form_id', 'form_type']);
        });
    }

    public function down()
    {
        Schema::table('laporan_informasi', function (Blueprint $table) {
            $table->dropIndex(['form_id', 'form_type']);
        });
    }
}
