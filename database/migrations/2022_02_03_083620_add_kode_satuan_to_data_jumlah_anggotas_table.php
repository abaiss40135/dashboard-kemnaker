<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeSatuanToDataJumlahAnggotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_jumlah_anggotas', function (Blueprint $table) {
            $table->string('kode_satuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_jumlah_anggotas', function (Blueprint $table) {
            $table->dropColumn('kode_satuan');
        });
    }
}
