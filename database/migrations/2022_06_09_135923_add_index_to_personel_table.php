<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToPersonelTable extends Migration
{
    public function up()
    {
        Schema::table('personel', function (Blueprint $table) {
            $table->index(['user_id']);
            $table->index(['nama']);
        });
    }

    public function down()
    {
        Schema::table('personel', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['nama']);
        });
    }
}
