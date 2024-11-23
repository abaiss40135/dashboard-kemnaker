<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataJumlahAnggotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_jumlah_anggotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kesatuan');
            $table->integer('jmlsaka_pa');
            $table->integer('jmlsaka_pi');
            $table->integer('kmdsaka_pa');
            $table->integer('kmdsaka_pi');
            $table->integer('kmlsaka_pa');
            $table->integer('kmlsaka_pi');
            $table->integer('jmlpamong_pa');
            $table->integer('jmlpamong_pi');
            $table->integer('kmdpamong_pa');
            $table->integer('kmdpamong_pi');
            $table->integer('kmlpamong_pa');
            $table->integer('kmlpamong_pi');
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
        Schema::dropIfExists('data_jumlah_anggotas');
    }
}
