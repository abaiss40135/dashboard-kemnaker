<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('tag_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug', 125)->index();
            $table->string('name', 125);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tag_groups');
    }
}