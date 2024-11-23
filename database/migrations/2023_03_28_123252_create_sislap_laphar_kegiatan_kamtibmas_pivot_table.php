<?php

use App\Models\Sislap\Nonlapbul\KegiatanCegahTindakPidanaKamtibmas\LapharKegiatanKamtibmas;
use App\Models\Sislap\Nonlapbul\KegiatanCegahTindakPidanaKamtibmas\ListKegiatan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSislapLapharKegiatanKamtibmasPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sislap_laphar_kegiatan_kamtibmas_pivot', function (Blueprint $table) {
            $table->foreignIdFor(LapharKegiatanKamtibmas::class)->onDelete('cascade');
            $table->foreignIdFor(ListKegiatan::class);
            $table->integer('jumlah')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sislap_laphar_kegiatan_kamtibmas_pivot');
    }
}
