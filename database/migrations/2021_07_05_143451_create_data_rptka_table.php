<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataRptkaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_rptka', function (Blueprint $table) {
            $table->id();
              //relasi ke table nomor_induk_berusaha
              $table->unsignedBigInteger('nib_id');
              $table->foreign('nib_id')
                  ->references('id')
                  ->on('nomor_induk_berusaha')
                  ->onDelete('cascade');

              $table->string('jenis_rptka', 2)->nullable();
              $table->string('no_rptka', 20)->nullable();
              $table->date('rptka_awal')->nullable();
              $table->date('rptka_akhir')->nullable();
              $table->decimal('rptka_gaji',20, 2)->nullable();
              $table->decimal('jumlah_tka_rptka', 11, 0)->nullable();
              $table->date('jangka_penggunaan_waktu')->nullable();
              $table->double('jangka_waktu_permohonan_rptka', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_rptka');
    }
}
