<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealisasiAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realisasi_anggarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('program_kegiatan');
            $table->string('bulan');
            $table->integer('pagu_awal')->default(0);
            $table->integer('pagu_revisi')->default(0);
            $table->integer('realisasi_rupiah')->default(0);
            $table->integer('realisasi_persen')->default(0);
            $table->integer('sisa_rupiah')->default(0);
            $table->integer('sisa_persen')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->string('kode_satuan');
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
        Schema::dropIfExists('realisasi_anggarans');
    }
}
