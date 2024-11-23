<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->index(['role_id', 'user_id']);
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->index(['name']);
            $table->index(['alias']);
        });
    }

    public function down()
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropIndex(['role_id', 'user_id']);
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['alias']);
        });
    }
};
