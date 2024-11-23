<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAliasesTable extends Migration
{
    public function up()
    {
        Schema::create('aliases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('column_name');
            $table->text('replace');
            $table->morphs('replaceable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aliases');
    }
}
