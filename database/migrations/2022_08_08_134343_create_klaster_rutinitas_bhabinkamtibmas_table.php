<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS klaster_rutinitas_bhabinkamtibmas');
        Schema::create('klaster_rutinitas_bhabinkamtibmas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->integer('personel_id')->nullable();
            $table->foreign('personel_id')->references('personel_id')->on('personel');
            $table->bigInteger('total_laporan')->default(0);
            /**
             * KURANG, CUKUP, AKTIF
             */
            $table->string('klaster_rutinitas')->default("KURANG");
            $table->smallInteger('minggu_ke')->unsigned();
            $table->smallInteger('bulan')->unsigned();
            $table->year('tahun');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('klaster_rutinitas_bhabinkamtibmas');
    }
};
