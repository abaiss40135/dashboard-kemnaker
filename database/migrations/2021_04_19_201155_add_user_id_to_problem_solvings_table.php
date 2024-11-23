<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToProblemSolvingsTable extends Migration
{
    public function up()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
    }
}
