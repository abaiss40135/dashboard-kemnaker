<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenanggungJawabsTable extends Migration
{
    public function up()
    {
        Schema::create('penanggung_jawab', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nib_id');
            $table->foreign('nib_id')
                ->references('id')
                ->on('nomor_induk_berusaha')
                ->onDelete('cascade');

            $table->string('flag_asing', 1)->nullable();
            $table->string('jns_identitas_penanggung_jwb', 2)->nullable();
            $table->string('no_identitas_penanggung_jwb', 100)->nullable();
            $table->string('nama_penanggung_jwb', 500)->nullable();
            $table->string('jabatan_penanggung_jwb', 250)->nullable();
            $table->string('kebangsaan_penanggung_jwb', 2)->nullable();
            $table->string('negara_asal_penanggung_jwb', 2)->nullable();
            $table->string('npwp_penanggung_jwb', 15)->nullable();
            $table->string('alamat_penanggung_jwb', 1024)->nullable();
            $table->string('jalan_penanggung_jwb', 50)->nullable();
            $table->string('blok_penanggung_jwb', 10)->nullable();
            $table->string('no_penanggung_jwb', 10)->nullable();
            $table->string('rt_rw_penanggung_jwb', 255)->nullable();
            $table->string('kelurahan_penanggung_jwb', 255)->nullable();
            $table->string('daerah_id_penanggung_jwb', 10)->nullable();
            $table->string('kode_pos_penanggung_jwb', 5)->nullable();
            $table->string('no_telp_penanggung_jwb', 50)->nullable();
            $table->string('no_hp_penanggung_jwb', 50)->nullable();
            $table->string('no_fax_penanggung_jwb', 50)->nullable();
            $table->string('email_penanggung_jwb', 100)->nullable();
            $table->string('flag_pajak_penanggung_jwb', 2)->nullable();
            $table->string('ket_pajak_penanggung_jwb', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penanggung_jawab');
    }
}
