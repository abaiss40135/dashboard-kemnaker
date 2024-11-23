<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileDsTable extends Migration
{
    public function up()
    {
        Schema::create('file_ds', function (Blueprint $table) {
            $table->string('id_izin')->primary();
            $table->string('nib');
            $table->foreign('nib')
                ->references('nib')
                ->on('bujps');
            $table->text('file_izin');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_ds');
    }
}
