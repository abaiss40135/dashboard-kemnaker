<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_checklist', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nib_id');
            $table->foreign('nib_id')
                ->references('id')
                ->on('nomor_induk_berusaha')
                ->onDelete('cascade');

            $table->string('id_produk',25)->nullable();
            $table->string('id_proyek',25)->nullable();
            $table->string('id_izin',25)->nullable();
            $table->string('jenis_izin',3)->nullable();
            $table->string('kd_izin',13)->nullable();
            $table->string('kd_daerah',10)->nullable();
            $table->string('nama_izin',255)->nullable();
            $table->string('instansi',100)->nullable();
            $table->decimal('id_bidang_spesifik',19, 0)->nullable();
            $table->string('bidang_spesifik',255)->nullable();
            $table->decimal('id_kewenangan',19, 0)->nullable();
            $table->string('parameter_kewenangan',255)->nullable();
            $table->string('kewenangan',2)->nullable();
            $table->string('flag_checklist',1)->nullable();
            $table->string('flag_transaksional',1)->nullable();
            $table->string('flag_perpanjangan',1)->nullable();
            $table->string('no_izin',150)->nullable();
            $table->date('tgl_izin')->nullable();
            $table->string('file_izin',65535)->nullable();
            $table->string('kd_dokumen')->nullable();
            $table->string('nm_dokumen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_checklist');
    }
}
