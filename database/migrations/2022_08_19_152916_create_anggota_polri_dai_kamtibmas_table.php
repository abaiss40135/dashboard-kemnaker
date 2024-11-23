<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaPolriDaiKamtibmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('anggota_polri_dai_kamtibmas');
        Schema::create('anggota_polri_dai_kamtibmas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("dai_kamtibmas_id");
            $table->string("pangkat");
            $table->string("nrp");
            $table->string("jabatan");
            $table->string("kesatuan");
            $table->timestamps();

            $table->foreign('dai_kamtibmas_id')->references('id')->on('dai_kamtibmas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggota_polri_dai_kamtibmas');
    }
}
