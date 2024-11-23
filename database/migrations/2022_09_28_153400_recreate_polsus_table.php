<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreatePolsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('polsus');
        Schema::create('polsus', function(Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\User::class, "user_id");
            $table->foreignIdFor(\App\Models\Instansi::class);
            $table->string("jenis_polsus");

            $table->string('nama');
            $table->string('no_hp');
            $table->string('detail_alamat');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('rt');
            $table->string('rw');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');

            $table->string("golongan");
            $table->string("pangkat");
            $table->string("jabatan");
            $table->string("no_nip");
            $table->string("jenjang_diklat");

            $table->string("no_ijazah")->nullable();
            $table->string("tempat_dikeluarkan_ijazah")->nullable();
            $table->date("tanggal_dikeluarkan_ijazah")->nullable();

            $table->integer("kepemilikan_kta")->nullable();
            $table->string("no_skep")->nullable();
            $table->string('no_kta')->nullable();
            $table->string("pejabat_yang_mengeluarkan_kta")->nullable();
            $table->date("expired_kta")->nullable();

            $table->integer("memiliki_izin_senpi_amunisi")->nullable();
            $table->string("no_izin_pegang_senpi")->nullable();
            $table->string("pejabat_yang_mengeluarkan_izin_pegang_senpi")->nullable();
            $table->date("expired_izin_pegang")->nullable();

            $table->string("foto_profile")->default('https://docplayer.info/docs-images/77/75997698/images/24-2.jpg');

            $table->string("kelengkapan_perorangan");
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
        Schema::dropIfExists('polsus');
    }
}
