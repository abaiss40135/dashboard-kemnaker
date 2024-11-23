<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBujpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bujps', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama_badan_usaha');
            $table->string('tipe_badan_usaha');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('detail_alamat', 5000);
            $table->string('kode_pos');
            $table->string('nomor_telepon');
            $table->string('email_badan_usaha');
            $table->string('website_badan_usaha');
            $table->string('npwp_badan_usaha');
            $table->string('logo_badan_usaha');
            $table->string('bidang_usaha');
            $table->string('panggilan_penanggung_jawab');
            $table->string('nama_penanggung_jawab');
            $table->string('nomor_ktp_penanggung_jawab' );
            $table->string('nomor_telepon_penanggung_jawab' );
            $table->string('username')->unique();
            $table->string('password');
            $table->string('jabatan_penanggung_jawab');
            $table->string('foto_penanggung_jawab');
            $table->string('foto_ktp_penanggung_jawab');
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
        Schema::dropIfExists('bujps');
    }
}