<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropKodeDaerahLapharMinyakGorengsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laphar_minyak_gorengs', function (Blueprint $table) {
            $table->dropColumn('kode_daerah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laphar_minyak_gorengs', function (Blueprint $table) {
            $table->string('kode_daerah');
        });
    }
}
