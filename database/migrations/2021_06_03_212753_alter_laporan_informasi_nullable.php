<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLaporanInformasiNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_informasi' , function(Blueprint $table){
            $table->string('nilai_abjad')->nullable()->default('...')->change();
            $table->string('bidang')->nullable()->default('...')->change();
            $table->text('uraian')->nullable()->default('...')->change();   
            $table->string('form_type')->nullable()->default('...')->change();
            $table->smallInteger('nilai_angka')->nullable()->change();
            $table->unsignedBigInteger('form_id')->nullable()->change();
            $table->string('form_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
