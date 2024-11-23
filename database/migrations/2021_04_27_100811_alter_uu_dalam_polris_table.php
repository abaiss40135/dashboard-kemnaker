<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUuDalamPolrisTable extends Migration
{
    public function up()
    {
        Schema::table('uu_dalam_polris', function (Blueprint $table) {
            $table->text('deskripsi_uu')->change();
            $table->text('file_uu')->change();
        });
    }

    public function down()
    {
        Schema::table('uu_dalam_polris', function (Blueprint $table) {
            $table->string('deskripsi_uu')->change();
            $table->string('file_uu')->change();
        });
    }
}
