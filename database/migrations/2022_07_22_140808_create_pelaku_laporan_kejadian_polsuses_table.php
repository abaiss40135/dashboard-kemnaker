<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelakuLaporanKejadianPolsusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pelaku_laporan_kejadian_polsuses');
        Schema::create('pelaku_laporan_kejadian_polsuses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\LaporanKejadianPolsus::class, "laporan_id");
            $table->string("nama");
            $table->string("usia");
            $table->string("pekerjaan");
            $table->string("alamat");
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
        Schema::dropIfExists('pelaku_laporan_kejadian_polsuses');
    }
}
