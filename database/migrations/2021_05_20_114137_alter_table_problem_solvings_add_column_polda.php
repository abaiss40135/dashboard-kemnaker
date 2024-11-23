<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProblemSolvingsAddColumnPolda extends Migration
{
    public function up()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->string('polda')->nullable();
        });
    }

    public function down()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->dropColumn('polda');
        });
    }
}
