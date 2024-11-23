<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPokdarkamtibmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pokdarkamtibmas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('daerah');
            $table->string('alamat_sekretariat');
            $table->string('nama_ketua');
            $table->string('no_hp');
            $table->string('jumlah_anggota');
            $table->string('kegiatan');
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
        Schema::dropIfExists('data_pokdarkamtibmas');
    }
}
