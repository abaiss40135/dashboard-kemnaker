<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeSatuanToDataPolsusKlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_polsus_kls', function (Blueprint $table) {
            $table->string('kode_satuan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_polsus_kls', function (Blueprint $table) {
            $table->dropColumn('kode_satuan');
        });
    }
}