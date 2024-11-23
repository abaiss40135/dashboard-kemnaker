<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaKeluargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota_keluargas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dds_warga_id');
            $table->foreign('dds_warga_id')->references('id')->on('dds_wargas')->onDelete('cascade');
            $table->string('nama' , 1000);
            $table->string('jenis_kelamin' , 1000);
            $table->string('hubungan' , 1000);
            $table->string('nomor_telepon' , 1000);
            $table->string('tempat_lahir' , 1000);
            $table->string('tanggal_lahir' , 1000);
            $table->string('status_pekerjaan' , 1000);
            
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
        Schema::dropIfExists('anggota_keluargas');
    }
}
