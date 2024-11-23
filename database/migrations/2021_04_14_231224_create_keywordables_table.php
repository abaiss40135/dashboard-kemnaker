<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeywordablesTable extends Migration
{
    public function up()
    {
        Schema::create('keywordables', function (Blueprint $table) {
            $table->unsignedBigInteger('keyword_id');
            $table->morphs('keywordable');
        });
    }

    public function down()
    {
        Schema::dropIfExists('keywordables');
    }
}
