<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKommasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kommas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_kommas'); //
            $table->string('badan_hukum');
            $table->string('akta_notaris'); //
            $table->string('pengesahan');
            $table->string('npwp'); //
            $table->string('duk_pembina');
            $table->string('pengurus');
            $table->string('jenis_komunitas');
            $table->string('kebijakan_komunitas');
            $table->integer('jumlah_anggota'); //
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
        Schema::dropIfExists('data_kommas');
    }
}
