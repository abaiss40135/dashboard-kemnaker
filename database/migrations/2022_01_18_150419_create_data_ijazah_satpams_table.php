<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataIjazahSatpamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_ijazah_satpams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bulan');
            $table->integer('ijazah_gp_guna');
            $table->integer('ijazah_gp_rusak');
            $table->integer('ijazah_gp_jumlah');
            $table->integer('ijazah_gp_sisa');
            $table->integer('ijazah_gp_no_blangko');
            $table->integer('ijazah_gm_guna');
            $table->integer('ijazah_gm_rusak');
            $table->integer('ijazah_gm_jumlah');
            $table->integer('ijazah_gm_sisa');
            $table->integer('ijazah_gm_no_blangko');
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
        Schema::dropIfExists('data_ijazah_satpams');
    }
}
