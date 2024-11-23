<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPolsusTableNullableDesa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('polsus', function (Blueprint $table) {
            $table->string("desa")->nullable()->change();
            $table->string("kecamatan")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polsus', function (Blueprint $table) {
            $table->string("desa")->change();
            $table->string("kecamatan")->change();
        });
    }
}
