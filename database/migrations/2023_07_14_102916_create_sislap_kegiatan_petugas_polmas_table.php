<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSislapKegiatanPetugasPolmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sislap_kegiatan_petugas_polmas', function (Blueprint $table) {
            $table->id();
            $table->string('polda');
            $table->string('polres')->nullable();
            $table->integer('sambang')->default(0);
            $table->integer('pemecahan_masalah')->default(0);
            $table->integer('laporan_informasi')->default(0);
            $table->integer('penanganan_perkara_ringan')->default(0);
            $table->string('lampiran');
            $table->string('kode_satuan');
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
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
        Schema::dropIfExists('sislap_kegiatan_petugas_polmas');
    }
}
