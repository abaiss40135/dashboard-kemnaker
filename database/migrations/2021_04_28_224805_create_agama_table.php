<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgamaTable extends Migration
{
    public function up()
    {
        Schema::create('agama', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->index('nama');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agama');
    }
}
