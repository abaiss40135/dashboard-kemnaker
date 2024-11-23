<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDeteksiDinisTableRemoveUraianInformasi extends Migration
{
    public function up()
    {
        Schema::table('deteksi_dinis', function (Blueprint $table) {
            $table->dropColumn(['metode_mendapatkan_informasi', 'bidang_informasi', 'uraian_informasi']);
        });
    }

    public function down()
    {
        Schema::table('deteksi_dinis', function (Blueprint $table) {
            $table->string('metode_mendapatkan_informasi')->nullable();
            $table->string('bidang_informasi');
            $table->text('uraian_informasi');
        });
    }
}
