<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSenpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_senpis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kementerian_lembaga');
            $table->integer('senpi_larpan_jml');
            $table->integer('senpi_larpan_bb');
            $table->integer('senpi_larpan_rr');
            $table->integer('senpi_larpan_rb');
            $table->integer('senpi_larpend_jml');
            $table->integer('senpi_larpend_bb');
            $table->integer('senpi_larpend_rr');
            $table->integer('senpi_larpend_rb');
            $table->integer('amunisi_larpan_jml');
            $table->integer('amunisi_larpan_bb');
            $table->integer('amunisi_larpan_rr');
            $table->integer('amunisi_larpan_rb');
            $table->integer('amunisi_larpend_jml');
            $table->integer('amunisi_larpend_bb');
            $table->integer('amunisi_larpend_rr');
            $table->integer('amunisi_larpend_rb');
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
        Schema::dropIfExists('data_senpis');
    }
}
