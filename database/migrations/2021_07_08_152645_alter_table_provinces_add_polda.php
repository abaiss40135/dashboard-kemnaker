<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProvincesAddPolda extends Migration
{
    public function up()
    {
        Schema::table('provinces', function (Blueprint $table) {
            $table->string('polda')->nullable();
        });
    }

    public function down()
    {
        Schema::table('provinces', function (Blueprint $table) {
            $table->dropColumn(['polda']);
        });
    }
}
