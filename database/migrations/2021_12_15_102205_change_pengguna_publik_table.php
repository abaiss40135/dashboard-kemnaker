<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePenggunaPublikTable extends Migration
{
    public function up()
    {
        Schema::table('pengguna_publik', function (Blueprint $table) {
            $table->string('type', 17)->default('publik');
        });
    }

    public function down()
    {
        Schema::table('pengguna_publik', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
