<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaggedsTable extends Migration
{
    public function up()
    {
        Schema::create('tagged', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('taggable');
            $table->string('tag_name', 125);
            $table->string('tag_slug', 125)->index();
            $table->index(['taggable_id', 'taggable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('taggeds');
    }
}
