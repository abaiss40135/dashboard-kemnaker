<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPolsusTableRemoveEmailPassword extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('polsus', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('polsus', function (Blueprint $table) {
            $table->string('email')->unique();
            $table->string('password');
        });
    }
}
