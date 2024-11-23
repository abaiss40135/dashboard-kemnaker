<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sislap_penanganan_pasca_gempa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personel_id')
                ->constrained('personel', 'personel_id');
            $table->char('district_code', 7);
            $table->foreign('district_code')
                ->references('code')
                ->on('districts')->cascadeOnUpdate();
            $table->date('tanggal');
            $table->foreignId('jenis_kegiatan_id')->constrained('sislap_jenis_giat_pasca_gempa');
            $table->text('uraian_kegiatan');
            $table->foreignId('user_id');
            $table->string('kode_satuan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penanganan_pasca_gempas');
    }
};
