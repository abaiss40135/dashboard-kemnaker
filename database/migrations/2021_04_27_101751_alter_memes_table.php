<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMemesTable extends Migration
{
    public function up()
    {
        Schema::table('memes', function (Blueprint $table) {
            $table->text('caption')->change();
        });
    }

    public function down()
    {
        Schema::table('memes', function (Blueprint $table) {
            $table->string('caption')->change();
        });
    }
}
