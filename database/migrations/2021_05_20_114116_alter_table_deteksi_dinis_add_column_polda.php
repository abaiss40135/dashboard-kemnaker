<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDeteksiDinisAddColumnPolda extends Migration
{
    public function up()
    {
        Schema::table('deteksi_dinis', function (Blueprint $table) {
            $table->string('polda')->nullable();
        });
    }

    public function down()
    {
        Schema::table('deteksi_dinis', function (Blueprint $table) {
            $table->dropColumn('polda');
        });
    }
}
