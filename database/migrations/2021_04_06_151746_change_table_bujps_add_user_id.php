<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableBujpsAddUserId extends Migration
{
    public function up()
    {
        Schema::table('bujps', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users');

            $table->dropColumn(['username', 'password']);
        });
    }

    public function down()
    {
        Schema::table('bujps', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('bujp');
        });
    }
}