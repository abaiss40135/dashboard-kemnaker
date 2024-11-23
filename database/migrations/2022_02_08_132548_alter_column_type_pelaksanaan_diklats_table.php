<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnTypePelaksanaanDiklatsTable extends Migration
{
    public function up()
    {
        Schema::table('pelaksanaan_diklats', function (Blueprint $table) {
            $table->string('waktu')->change();
            $table->string('tanggal_buka')->change();
            $table->string('tanggal_tutup')->change();
        });
    }

    public function down()
    {
        Schema::table('pelaksanaan_diklats', function (Blueprint $table) {
            $table->time('waktu')->change();
            $table->date('tanggal_buka')->change();
            $table->date('tanggal_tutup')->change();
        });
    }
}
