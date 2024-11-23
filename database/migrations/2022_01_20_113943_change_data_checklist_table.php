<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataChecklistTable extends Migration
{
    public function up()
    {
        Schema::table('data_checklist', function (Blueprint $table) {
            $table->text('bidang_spesifik')->change();
        });
    }

    public function down()
    {
        Schema::table('data_checklist', function (Blueprint $table) {
            $table->string('bidang_spesifik', 255)->change();
        });
    }
}
