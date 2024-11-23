<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRtAndRwColumnToNullableOnPolsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('polsus', function (Blueprint $table) {
            $table->string("rt")->nullable()->change();
            $table->string("rw")->nullable()->change();
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
            $table->string("rt")->change();
            $table->string("rw")->change();
        });
    }
}
