<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKommasKbppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kommas_kbpps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kesatuan');
            $table->string('kbpp_polri');
            $table->string('senkom');
            $table->string('fkppi');
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
        Schema::dropIfExists('kommas_kbpps');
    }
}
