<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupervisorPolmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisor_polmas', function (Blueprint $table) {
            $table->id();
            $table->string('polda');
            $table->string('polres');
            $table->integer('jumlah_supervisor_polres');
            $table->integer('jumlah_supervisor_polsek');
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
        Schema::dropIfExists('supervisor_polmas');
    }
}
