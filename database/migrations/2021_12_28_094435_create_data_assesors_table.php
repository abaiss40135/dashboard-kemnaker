<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataAssesorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_assesors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('polri');
            $table->string('non_polri');
            $table->string('no_reg_assesor');
            $table->string('gu');
            $table->string('gm');
            $table->string('gp');
            $table->string('jml');
            $table->string('status');
            $table->string('keterangan');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_assesors');
    }
}
