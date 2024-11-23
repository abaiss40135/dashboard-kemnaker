<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lokasi_penugasan_polisi_rw', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class);
            $table->string('province_code', 2);
            $table->string('city_code', 4);
            $table->string('district_code', 7);
            $table->string('village_code', 10);
            $table->string('dusun');
            $table->string('rw');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi_penugasan_polisi_rw');
    }
};
