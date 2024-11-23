<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnLokasiPenugasansTable extends Migration
{
    public function up()
    {
        Schema::table('lokasi_penugasans', function (Blueprint $table) {
            $table->renameColumn('provinsi_code', 'province_code');
            $table->renameColumn('kota_code', 'city_code');
            $table->renameColumn('kecamatan_code', 'district_code');
            $table->renameColumn('desa_code', 'village_code');

            $table->foreign('province_code')
                ->references('code')
                ->on('provinces')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('city_code')
                ->references('code')
                ->on('cities')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_code')
                ->references('code')
                ->on('districts')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('village_code')
                ->references('code')
                ->on('villages')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('lokasi_penugasans', function (Blueprint $table) {
            //
        });
    }
}
