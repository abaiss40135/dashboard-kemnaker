<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelatihanKeamanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelatihan_keamanans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->foreignIdFor(\App\Models\Bujp::class, 'bujp_id');
            $table->string('no_sio');
            $table->string('pengguna_jasa');
            $table->string('alamat');
            $table->string('tempat_diklat');
            $table->string('pihak_yang_menyewakan_tempat')->nullable();
            $table->text('fasilitas');
            $table->string('jenis_diklat');
            $table->string('waktu_diklat_dari');
            $table->string('waktu_diklat_sampai');
            $table->integer('jumlah_peserta');
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
        Schema::dropIfExists('pelatihan_keamanans');
    }
}
