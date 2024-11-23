<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemSolvingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problem_solvings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('nama_petugas');
            $table->string('pangkat_petugas');
            $table->string('kelurahan');
            $table->date('tanggal_kejadian');
            $table->string('waktu_kejadian');
            $table->string('nama_pihak_1');
            $table->string('pekerjaan_pihak_1');
            $table->string('alamat_pihak_1');
            $table->string('provinsi_pihak_1');
            $table->string('kabupaten_pihak_1');
            $table->string('kecamatan_pihak_1');
            $table->string('desa_pihak_1');
            $table->string('rt_pihak_1');
            $table->string('rw_pihak_1');
            $table->string('nama_pihak_2');
            $table->string('pekerjaan_pihak_2');
            $table->string('alamat_pihak_2');
            $table->string('provinsi_pihak_2');
            $table->string('kabupaten_pihak_2');
            $table->string('kecamatan_pihak_2');
            $table->string('desa_pihak_2');
            $table->string('rt_pihak_2');
            $table->string('rw_pihak_2');
            $table->string('bidang_masalah');
            $table->string('keyword');
            $table->text('uraian_kejadian');
            $table->string('saksi');
            $table->text('uraian_problem_solving');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('problem_solvings');
    }
}
