<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKejadianSatpamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_kejadian_satpams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('satpam_id');
            $table->foreign('satpam_id')->references('id')->on('satpams')->onDelete('cascade');
            $table->string('hari_kejadian');
            $table->string('tanggal_kejadian');
            $table->string('waktu_kejadian');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('nama_jalan');
            $table->string('uraian_kejadian');
            $table->string('nama_pelaku');
            $table->string('jenis_kelamin_pelaku');
            $table->string('alamat_pelaku');
            $table->string('pekerjaan_pelaku');
            $table->string('nomor_telepon_pelaku');
            $table->string('nama_korban');
            $table->string('jenis_kelamin_korban');
            $table->string('alamat_korban');
            $table->string('pekerjaan_korban');
            $table->string('nomor_telepon_korban');
            $table->string('penyebab_kejadian');
            $table->string('hari_dilaporkan');
            $table->string('tanggal_dilaporkan');
            $table->string('waktu_dilaporkan');
            $table->string('tindak_pidana');
            $table->integer('jumlah_saksi');
            $table->string('bukti');
            $table->string('uraian_laporan');
            $table->string('tindakan');


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
        Schema::dropIfExists('laporan_kejadian_satpams');
    }
}
