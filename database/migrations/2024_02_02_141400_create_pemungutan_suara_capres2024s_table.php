<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemungutanSuaraCapres2024sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemungutan_suara_capres2024s', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class);
            $table->integer('suara_capres_1');
            $table->integer('suara_capres_2');
            $table->integer('suara_capres_3');
            $table->integer('suara_tidak_sah');
            $table->string('provinsi_kode')->nullable();
            $table->string('kabupaten_kode')->nullable();
            $table->string('kecamatan_kode')->nullable();
            $table->string('kelurahan_kode')->nullable();
            $table->text('uraian_hasil_suara')->nullable();
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
        Schema::dropIfExists('pemungutan_suara_capres2024s');
    }
}
