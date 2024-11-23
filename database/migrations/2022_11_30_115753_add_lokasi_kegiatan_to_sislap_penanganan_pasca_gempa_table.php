<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sislap_penanganan_pasca_gempa', function (Blueprint $table) {
            $table->string('lokasi_kegiatan');
        });
    }

    public function down()
    {
        Schema::table('sislap_penanganan_pasca_gempa', function (Blueprint $table) {
            $table->dropColumn('lokasi_kegiatan');
        });
    }
};
