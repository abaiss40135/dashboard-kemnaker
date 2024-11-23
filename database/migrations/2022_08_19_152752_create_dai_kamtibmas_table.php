<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaiKamtibmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('dai_kamtibmas');
        Schema::create('dai_kamtibmas', function (Blueprint $table) {
            $table->id();
            $table->string('polda');
            $table->string('polres');
            $table->string("nama");
            $table->string("perorangan_kelompok");
            $table->string("no_suket_pelatihan");
            $table->date("tanggal_suket");
            $table->string("no_skep_pengangkatan");
            $table->date("tanggal_skep");
            $table->string("no_kta");
            $table->date("tanggal_kta");
            $table->string("no_hp");
            $table->string("alamat");
            $table->string('kode_satuan');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dai_kamtibmas');
    }
}
