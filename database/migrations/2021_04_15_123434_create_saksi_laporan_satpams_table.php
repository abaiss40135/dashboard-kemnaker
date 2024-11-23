<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaksiLaporanSatpamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saksi_laporan_satpams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporan_kejadian_id');
            $table->foreign('laporan_kejadian_id')->references('id')
                  ->on('laporan_kejadian_satpams')->onDelete('cascade');
            $table->string('nama');
            $table->string('umur');
            $table->string('pekerjaan');
            $table->string('nomor_telepon');
            $table->string('alamat');
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
        Schema::dropIfExists('saksi_laporan_satpams');
    }
}
