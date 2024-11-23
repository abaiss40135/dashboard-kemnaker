<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPendapatWargasTable extends Migration
{
    public function up()
    {
        Schema::table('pendapat_wargas', function (Blueprint $table) {
            $table->text('uraian')->change();
        });
    }

    public function down()
    {
        Schema::table('pendapat_wargas', function (Blueprint $table) {
            $table->string('uraian')->change();
        });
    }
}
