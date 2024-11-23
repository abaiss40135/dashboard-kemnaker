<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableDdsWargas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->string('tempat_lahir_kepala_keluarga')->nullable()->default('...')->change();
            $table->string('tanggal_lahir_kepala_keluarga')->nullable()->default('...')->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            //
        });
    }
}
