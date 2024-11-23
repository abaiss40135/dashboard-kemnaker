<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

class CreateKawasanTable extends Migration
{
    public function up()
    {
        if (!Type::hasType('char')) {
            Type::addType('char', StringType::class);
        }
        Schema::create('kawasan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('province_code', 2);
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        if (!Type::hasType('char')) {
            Type::addType('char', StringType::class);
        }
        Schema::dropIfExists('kawasan');
    }
}
