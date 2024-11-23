<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ketua_rw', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->nullable();
            $table->string('nama');
            $table->string('hp')->nullable();
            $table->string('village_code', 10);
            $table->text('alamat')->nullable();
            $table->string('rw');
            $table->foreignIdFor(\App\Models\Personel::class, 'personel_id');
            $table->foreignIdFor(\App\Models\PolisiRW\KategoriKegiatan::class)->nullable();
            $table->foreignIdFor(\App\Models\PolisiRW\KategoriKerawanan::class)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ketua_rw');
    }
};
