<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomunitasBinaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komunitas_binaans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('komunitas_binaan');
            $table->string('jumlah_komunitas_binaan');
            $table->string('jumlah_anggota');
            $table->string('peran_polri');
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
        Schema::dropIfExists('komunitas_binaans');
    }
}
