<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnPolresOnRekapPenghargaansTable extends Migration
{
    public function up()
    {
        Schema::table('rekap_penghargaans', function (Blueprint $table) {
            $table->string('polres')->change();
        });
    }

    public function down()
    {
    }
}
