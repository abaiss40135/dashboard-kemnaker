<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanInformasiTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_informasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bidang', 10);
            $table->text('uraian');
            $table->string('metode', 100)->nullable();
            $table->string('nilai_abjad', 1);
            $table->tinyInteger('nilai_angka');
            $table->unsignedBigInteger('form_id');
            $table->string('form_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_informasi');
    }
}
