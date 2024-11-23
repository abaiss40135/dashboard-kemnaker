<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriInformasisTable extends Migration
{
    public function up()
    {
        Schema::create('kategori_informasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('icon_primary');
            $table->text('icon_secondary');
            $table->string('description');
            $table->string('query');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_informasi');
    }
}
