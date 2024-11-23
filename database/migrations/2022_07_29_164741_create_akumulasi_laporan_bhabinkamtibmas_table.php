<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkumulasiLaporanBhabinkamtibmasTable extends Migration
{
    public function up()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS akumulasi_laporan_bhabinkamtibmas');
        Schema::create('akumulasi_laporan_bhabinkamtibmas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('personel_id')->nullable();
            $table->foreign('personel_id')->references('personel_id')->on('personel');
            $table->bigInteger('jumlah_dds')->default(0);
            $table->bigInteger('jumlah_deteksi_dini')->default(0);
            $table->bigInteger('jumlah_ps')->default(0);
            $table->bigInteger('jumlah_ps_eksekutif')->default(0);
            $table->bigInteger('jumlah_ps_non_sengketa')->default(0);
            $table->string('periode', 7);
            $table->timestamps();
        });
        Schema::table('akumulasi_laporan_bhabinkamtibmas', function (Blueprint $table) {
            $table->unique(['user_id', 'periode']);
        });
    }

    public function down()
    {
        Schema::table('akumulasi_laporan_bhabinkamtibmas', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'periode']);
        });
        Schema::dropIfExists('akumulasi_laporan_bhabinkamtibmas');
    }
}
