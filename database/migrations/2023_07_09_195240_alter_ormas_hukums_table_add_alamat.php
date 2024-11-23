<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrmasHukumsTableAddAlamat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ormas_hukums', function (Blueprint $table) {
            $table->bigInteger('provinsi_code')->nullable();
            $table->bigInteger('kabupaten_code')->nullable();
            $table->bigInteger('kecamatan_code')->nullable();
            $table->bigInteger('desa_code')->nullable();
            $table->string('jalan')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->renameColumn('no_hp', 'no_hp_ketua');
            $table->renameColumn('tipe', 'type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ormas_hukums', function (Blueprint $table) {
            $table->dropColumn('provinsi_code');
            $table->dropColumn('kabupaten_code');
            $table->dropColumn('kecamatan_code');
            $table->dropColumn('desa_code');
            $table->dropColumn('jalan');
            $table->dropColumn('rt');
            $table->dropColumn('rw');
            $table->renameColumn('no_hp_ketua', 'no_hp');
            $table->renameColumn('type', 'tipe');
        });
    }
}
