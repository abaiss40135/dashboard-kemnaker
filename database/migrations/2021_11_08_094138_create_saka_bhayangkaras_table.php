<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSakaBhayangkarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saka_bhayangkaras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kesatuan', 30)->nullable();
            $table->text('uraian')->nullable();
            $table->string('sasaran', 100)->nullable();
            $table->string('hasil', 255)->nullable();
            $table->string('keterangan', 100)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('saka_bhayangkaras');
    }
}
