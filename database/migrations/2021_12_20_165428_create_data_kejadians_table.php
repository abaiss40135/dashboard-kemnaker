<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKejadiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kejadians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kementerian');
            $table->string('tindak_pidana');
            $table->string('kronologi');
            $table->string('tindak_lanjut');
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
        Schema::dropIfExists('data_kejadians');
    }
}
