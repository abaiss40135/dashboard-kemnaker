<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDdsWargasTableAddIndex extends Migration
{
    public function up()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->index(['nama_kepala_keluarga', 'desa_kepala_keluarga', 'nama_penerima_kunjungan']);
        });
    }

    public function down()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->dropIndex(['nama_kepala_keluarga', 'desa_kepala_keluarga', 'nama_penerima_kunjungan']);
        });
    }
}
