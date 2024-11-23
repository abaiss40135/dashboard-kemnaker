<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembinaPolmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembina_polmas', function (Blueprint $table) {
            $table->id();
            $table->string('polda');
            $table->string('polres');
            $table->integer('jumlah_pembina_polda');
            $table->integer('jumlah_pembina_polres');
            $table->string('lampiran_file');
            $table->string('kode_satuan');
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
        Schema::dropIfExists('pembina_polmas');
    }
}
