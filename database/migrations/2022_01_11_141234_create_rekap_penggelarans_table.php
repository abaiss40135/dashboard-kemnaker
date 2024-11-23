<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapPenggelaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_penggelarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tgl_input_data');
            $table->string('polres');
            $table->string('jumlah_desa');
            $table->string('jumlah_kelurahan');
            $table->string('jumlah_bhabin');
            $table->string('bina1_desa');
            $table->string('bina2_desa');
            $table->string('bina3_desa');
            $table->string('bina4_desa');
            $table->string('desa_kel_binaan');
            $table->string('desa_kel_sentuhan');
            $table->string('desa_kel_pantauan');
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
        Schema::dropIfExists('rekap_penggelarans');
    }
}
