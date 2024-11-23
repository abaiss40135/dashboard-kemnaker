<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInfografisTable extends Migration
{
    public function up()
    {
        Schema::table('infografis', function (Blueprint $table) {
            $table->text('deskripsi')->change();
        });
    }

    public function down()
    {
        Schema::table('infografis', function (Blueprint $table) {
            $table->string('deskripsi')->change();
        });
    }
}
