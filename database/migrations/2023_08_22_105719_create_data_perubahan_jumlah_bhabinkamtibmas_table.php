<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPerubahanJumlahBhabinkamtibmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_perubahan_jumlah_bhabinkamtibmas', function (Blueprint $table) {
            $table->id();
            $table->string('no_skep');
            $table->string('file_skep');
            $table->string('jumlah_bhabinkamtibmas');
            $table->string('polda');
            $table->string('polres');
            $table->string('polsek');
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
        Schema::dropIfExists('data_perubahan_jumlah_bhabinkamtibmas');
    }
}
