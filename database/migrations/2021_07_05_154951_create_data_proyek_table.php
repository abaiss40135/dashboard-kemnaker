<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataProyekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_proyek', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nib_id');
            $table->foreign('nib_id')
                ->references('id')
                ->on('nomor_induk_berusaha')
                ->onDelete('cascade');

            $table->string('id_proyek',25) ->unique();
            $table->string('nomor_proyek',26) ->nullable();
            $table->string('uraian_usaha',255) ->nullable();
            $table->double('jumlah_tki_l',10) ->nullable();
            $table->double('jumlah_tki_p',10) ->nullable();
            $table->double('jumlah_tka_l',10) ->nullable();
            $table->double('jumlah_tka_p',10) ->nullable();
            $table->string('kbli',7) ->nullable();
            $table->string('sektor',3) ->nullable();
            $table->string('memiliki_menguasai',1) ->nullable();
            $table->string('jenis_lokasi',2) ->nullable();
            $table->string('status_tanah',2) ->nullable();
            $table->double('luas_tanah',10) ->nullable();
            $table->string('satuan_luas_tanah',2) ->nullable();
            $table->decimal('pembelian_pematang_tanah',19, 0) ->nullable();
            $table->decimal('bangunan_gedung',19, 0) ->nullable();
            $table->decimal('mesin_peralatan',19, 0) ->nullable();
            $table->decimal('mesin_peralatan_usd',19, 0) ->nullable();
            $table->decimal('investasi_lain',19, 0) ->nullable();
            $table->decimal('sub_jumlah',19, 0) ->nullable();
            $table->decimal('modal_kerja',19, 0) ->nullable();
            $table->decimal('jumlah_investasi',19, 0) ->nullable();
            $table->date('tanggal_kurs') ->nullable();
            $table->decimal('nilai_kurs',19, 0) ->nullable();
            $table->decimal('kd_kawasan',11, 0) ->nullable();
            $table->string('jawab_lokasi_b',1) ->nullable();
            $table->string('jawab_lokasi_c',1) ->nullable();
            $table->string('jawab_lokasi_d',1) ->nullable();
            $table->string('jawab_lokasi_e',1) ->nullable();
            $table->string('jawab_lokasi_f',1) ->nullable();
            $table->string('jawab_lokasi_g',1) ->nullable();
            $table->string('flag_perluasan',1) ->nullable();
            $table->string('flag_cabang',1) ->nullable();
            $table->string('npwp_cabang',15) ->nullable();
            $table->string('nama_cabang',255) ->nullable();
            $table->string('jenis_identitas_pj',2) ->nullable();
            $table->string('no_identitas_pj',16) ->nullable();
            $table->string('nama_pj',100) ->nullable();
            $table->string('status_proyek',2) ->nullable();
            $table->string('jenis_proyek',2) ->nullable();
            $table->string('nama_kegiatan',255) ->nullable();
            $table->string('flag_merger',1) ->nullable();
            $table->string('npwp_perseroan_merger',15) ->nullable();
            $table->string('nama_perseroan_merger',255) ->nullable();
            $table->string('skala_usaha')->nullable();
            $table->string('skala_resiko')->nullable();
            $table->string('deskripsi_kegiatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_proyek');
    }
}
