<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendapatWargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendapat_wargas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dds_warga_id');
            $table->foreign('dds_warga_id')->references('id')->on('dds_wargas')->onDelete('cascade');
            $table->string('jenis_pendapat');
            $table->string('nilai_informasi_abjad')->nullable()->default('...');
            $table->string('nilai_informasi_angka')->nullable()->default('...');
            $table->string('bidang_pendapat');
            $table->string('uraian');
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
        Schema::dropIfExists('pendapat_wargas');
    }
}
