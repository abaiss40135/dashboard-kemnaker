<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDistrictsTableAddIndex extends Migration
{
    public function up()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->index(['name']);
        });
    }

    public function down()
    {
        Schema::table('districts', function (Blueprint $table) {
            $table->dropIndex(['name']);
        });
    }
}