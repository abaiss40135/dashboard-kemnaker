<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNaskahsTable extends Migration
{
    public function up()
    {
        Schema::table('naskahs', function (Blueprint $table) {
            $table->text('deskripsi_naskah')->change();
            $table->text('file_naskah')->change();
        });
    }

    public function down()
    {
        Schema::table('naskahs', function (Blueprint $table) {
            $table->string('deskripsi_naskah')->change();
            $table->string('file_naskah')->change();
        });
    }
}
