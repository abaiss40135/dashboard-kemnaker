<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeSatuanToDataStokOpnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_stok_opnames', function (Blueprint $table) {
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
        Schema::table('data_stok_opnames', function (Blueprint $table) {
            $table->dropColumn('kode_satuan');
        });
    }
}