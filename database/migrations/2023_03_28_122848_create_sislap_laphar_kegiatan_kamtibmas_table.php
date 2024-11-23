<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSislapLapharKegiatanKamtibmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sislap_laphar_kegiatan_kamtibmas', function (Blueprint $table) {
            $table->id();
            $table->string('polda');
            $table->string('polres');
            $table->integer('total_kegiatan');
            $table->string('kode_satuan', 15);
            $table->foreignIdFor(User::class);
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
        Schema::dropIfExists('sislap_laphar_kegiatan_kamtibmas');
    }
}
