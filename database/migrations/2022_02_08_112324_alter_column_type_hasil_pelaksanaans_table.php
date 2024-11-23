<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnTypeHasilPelaksanaansTable extends Migration
{
    public function up()
    {
        Schema::table('hasil_pelaksanaans', function (Blueprint $table) {
            $table->string('waktu')->change();
            $table->string('tanggal_buka')->change();
            $table->string('tanggal_tutup')->change();
        });
    }

    public function down()
    {
        Schema::table('hasil_pelaksanaans', function (Blueprint $table) {
            $table->time('waktu')->change();
            $table->date('tanggal_buka')->change();
            $table->date('tanggal_tutup')->change();
        });
    }
}
