<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->index(['user_id']);
        });
    }

    public function down()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });
    }
};