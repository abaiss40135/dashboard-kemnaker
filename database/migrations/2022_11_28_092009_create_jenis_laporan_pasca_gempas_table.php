<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sislap_jenis_laporan_pasca_gempa', function (Blueprint $table) {
            $table->foreignId('jenis_giat_pasca_gempa_id')
                    ->constrained('sislap_jenis_giat_pasca_gempa');
            $table->string('jenis_laporan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sislap_jenis_laporan_pasca_gempa');
    }
};
