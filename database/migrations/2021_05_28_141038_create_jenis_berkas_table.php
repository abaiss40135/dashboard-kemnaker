<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisBerkasTable extends Migration
{
    public function up()
    {
        Schema::create('jenis_berkas', function (Blueprint $table) {
            $table->string('jenis')->primary();
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_berkas');
    }
}
