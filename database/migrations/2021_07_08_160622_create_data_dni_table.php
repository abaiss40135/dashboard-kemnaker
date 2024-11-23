<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_dni', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nib_id');
            $table->foreign('nib_id')
                ->references('id')
                ->on('nomor_induk_berusaha')
                ->onDelete('cascade');

            $table->double('kd_dni',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_dni');
    }
}
