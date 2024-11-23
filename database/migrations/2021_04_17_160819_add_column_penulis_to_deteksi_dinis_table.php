<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPenulisToDeteksiDinisTable extends Migration
{
    public function up()
    {
        Schema::table('deteksi_dinis', function (Blueprint $table) {
            $table->string('penulis')->nullable();
        });
    }

    public function down()
    {
        Schema::table('deteksi_dinis', function (Blueprint $table) {
            $table->dropColumn(['deteksi_dinis']);
        });
    }
}
