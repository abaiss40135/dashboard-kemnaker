<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTitikDeteksiDinisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deteksi_dinis' , function(Blueprint $table){
            $table->string('titik_mendapatkan_informasi')->nullable()->default('...');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deteksi_dinis' , function(Blueprint $table){
            $table->dropColumn('titik_mendapatkan_informasi');
        });
    }
}
