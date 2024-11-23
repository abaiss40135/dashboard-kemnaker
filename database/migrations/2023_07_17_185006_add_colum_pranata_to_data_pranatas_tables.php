<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumPranataToDataPranatasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_pranatas', function (Blueprint $table) {
            $table->string('nama_ketua_adat')->nullable();
            $table->integer('no_hp_ketua_adat')->nullable();
            $table->string('nama_petugas_polmas')->nullable();
            $table->string('pangkat_petugas_polmas')->nullable();
            $table->integer('no_hp_petugas_polmas')->nullable();
            $table->integer('rt')->nullable();
            $table->string('balai_adat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_pranatas', function (Blueprint $table) {
            $table->dropColumn('nama_ketua_adat');
            $table->dropColumn('no_hp_ketua_adat');
            $table->dropColumn('nama_petugas_polmas');
            $table->dropColumn('pangkat_petugas_polmas');
            $table->dropColumn('no_hp_petugas_polmas');
            $table->dropColumn('rt');
            $table->dropColumn('balai_adat');
        });
    }
}
