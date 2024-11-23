<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPsNonSengketasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ps_non_sengketas' , function( Blueprint $table ){
            $table->string('nama_narasumber')->nullable()->default('...');
            $table->string('pekerjaan_narasumber')->nullable()->default('...');
            $table->string('alamat_narasumber')->nullable()->default('...');
            $table->renameColumn('saksi' , 'pihak_terlibat');
            $table->renameColumn('uraian_problem_solving' , 'uraian_masalah');
            $table->date('tanggal_selesai')->nullable()->default('2021-04-30');
            $table->string('hari_selesai')->nullable()->default('...');
            $table->text('uraian_solusi')->nullable()->default('...');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ps_non_sengketas' , function( Blueprint $table ){
            $table->dropColumn(['nama_narasumber' , 'pekerjaan_narasumber' , 'hari_selesai' ,'tanggal_selesai', 'alamat_narasumber' , 'uraian_solusi']);
            $table->renameColumn('pihak_terlibat' , 'saksi');
            $table->renameColumn('uraian_masalah' , 'uraian_problem_solving');
        });
    }
}
