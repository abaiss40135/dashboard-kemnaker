<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataLokasiProyekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_lokasi_proyek', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_proyek_id');
            $table->foreign('data_proyek_id')
                ->references('id')
                ->on('data_proyek')
                ->onDelete('cascade');

            $table->string('id_proyek_lokasi',25)->unique();
            $table->string('proyek_daerah_id',10)->nullable();
            $table->string('kd_kawasan',3)->nullable();
            $table->string('alamat_usaha',65535)->nullable();
            $table->string('id_kegiatan',6)->nullable();
            $table->string('response_kegiatan',255)->nullable();
            $table->string('jenis_kawasan',2)->nullable();
            $table->string('jenis_lokasi',2)->nullable();
            $table->string('status_lokasi',2)->nullable();
            $table->json('data_lokasi_proyek')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_lokasi_proyek');
    }
}
