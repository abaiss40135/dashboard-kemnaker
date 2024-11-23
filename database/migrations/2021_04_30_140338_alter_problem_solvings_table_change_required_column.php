<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProblemSolvingsTableChangeRequiredColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->string('nama_pihak_1')->nullable()->change();
            $table->string('pekerjaan_pihak_1')->nullable()->change();
            $table->string('alamat_pihak_1')->nullable()->change();
            $table->string('provinsi_pihak_1')->nullable()->change();
            $table->string('kabupaten_pihak_1')->nullable()->change();
            $table->string('kecamatan_pihak_1')->nullable()->change();
            $table->string('desa_pihak_1')->nullable()->change();
            $table->string('rt_pihak_1')->nullable()->change();
            $table->string('rw_pihak_1')->nullable()->change();
            $table->string('nama_pihak_2')->nullable()->change();
            $table->string('pekerjaan_pihak_2')->nullable()->change();
            $table->string('alamat_pihak_2')->nullable()->change();
            $table->string('provinsi_pihak_2')->nullable()->change();
            $table->string('kabupaten_pihak_2')->nullable()->change();
            $table->string('kecamatan_pihak_2')->nullable()->change();
            $table->string('desa_pihak_2')->nullable()->change();
            $table->string('rt_pihak_2')->nullable()->change();
            $table->string('rw_pihak_2')->nullable()->change();
            $table->string('bidang_masalah')->nullable()->change();
            $table->string('saksi')->nullable()->change();
            $table->text('uraian_problem_solving')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->string('nama_pihak_1')->change();
            $table->string('pekerjaan_pihak_1')->change();
            $table->string('alamat_pihak_1')->change();
            $table->string('provinsi_pihak_1')->change();
            $table->string('kabupaten_pihak_1')->change();
            $table->string('kecamatan_pihak_1')->change();
            $table->string('desa_pihak_1')->change();
            $table->string('rt_pihak_1')->change();
            $table->string('rw_pihak_1')->change();
            $table->string('nama_pihak_2')->change();
            $table->string('pekerjaan_pihak_2')->change();
            $table->string('alamat_pihak_2')->change();
            $table->string('provinsi_pihak_2')->change();
            $table->string('kabupaten_pihak_2')->change();
            $table->string('kecamatan_pihak_2')->change();
            $table->string('desa_pihak_2')->change();
            $table->string('rt_pihak_2')->change();
            $table->string('rw_pihak_2')->change();
            $table->string('bidang_masalah')->change();
            $table->string('saksi')->change();
            $table->text('uraian_problem_solving')->change();
        });
    }
}