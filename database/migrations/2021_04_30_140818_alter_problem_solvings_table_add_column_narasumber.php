<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProblemSolvingsTableAddColumnNarasumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->string('nama_narasumber')->nullable()->default('...');
            $table->string('pekerjaan_narasumber')->nullable()->default('...');
            $table->string('alamat_narasumber')->nullable()->default('...');
            $table->string('hari_masalah_selesai')->nullable();
            $table->date('tanggal_masalah_selesai')->nullable();
            $table->dropColumn('bidang_masalah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
