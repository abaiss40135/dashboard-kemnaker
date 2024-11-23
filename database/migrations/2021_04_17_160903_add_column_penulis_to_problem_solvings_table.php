<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPenulisToProblemSolvingsTable extends Migration
{
    public function up()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->string('penulis')->nullable();
        });
    }

    public function down()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->dropColumn(['penulis']);
        });
    }
}
