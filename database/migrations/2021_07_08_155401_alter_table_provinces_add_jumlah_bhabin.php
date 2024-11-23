<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProvincesAddJumlahBhabin extends Migration
{
    public function up()
    {
        Schema::table('provinces', function (Blueprint $table) {
            $table->integer('jumlah_bhabin', false)->nullable();
        });
    }

    public function down()
    {
        Schema::table('provinces', function (Blueprint $table) {
            $table->dropColumn(['jumlah_bhabin']);
        });
    }
}
