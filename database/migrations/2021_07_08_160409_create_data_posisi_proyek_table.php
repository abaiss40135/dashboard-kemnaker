<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPosisiProyekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_posisi_proyek', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_lokasi_proyek_id');
            $table->foreign('data_lokasi_proyek_id')
                ->references('id')
                ->on('data_lokasi_proyek')
                ->onDelete('cascade');

            $table->string('id_proyek_posisi',25)->nullable();
            $table->string('id_proyek_lokasi',25)->nullable();
            $table->string('posisi_lokasi',2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_posisi_proyek');
    }
}
