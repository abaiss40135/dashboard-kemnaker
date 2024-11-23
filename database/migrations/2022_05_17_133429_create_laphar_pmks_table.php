<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapharPmksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laphar_pmks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polres');
            $table->string('jml_hewan_terinfeksi');
            $table->string('harga_daging');
            $table->string('ketersediaan_daging');
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
        Schema::dropIfExists('laphar_pmks');
    }
}
