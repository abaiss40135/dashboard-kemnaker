<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug', 125)->index();
            $table->string('name', 125);
            $table->boolean('suggest')->default(false);
            $table->integer('count')->unsigned()->default(0);
            $table->foreignId('tag_group_id')->nullable()->constrained('tag_groups');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
