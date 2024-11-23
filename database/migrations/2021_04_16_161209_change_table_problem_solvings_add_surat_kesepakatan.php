<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableProblemSolvingsAddSuratKesepakatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->string('surat_kesepakatan')->nullable();
            $table->dropColumn(['nama_petugas', 'pangkat_petugas', 'kelurahan']);
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
            $table->dropColumn('surat_kesepakatan');
            $table->string('nama_petugas');
            $table->string('pangkat_petugas');
            $table->string('kelurahan');
        });
    }
}
