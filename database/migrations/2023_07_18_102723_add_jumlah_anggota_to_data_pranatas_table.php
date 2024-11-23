<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJumlahAnggotaToDataPranatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_pranatas', function (Blueprint $table) {
            $table->integer('jumlah_anggota_pranata')->nullable();
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
            $table->dropColumn('jumlah_anggota_pranata');
        });
    }
}
