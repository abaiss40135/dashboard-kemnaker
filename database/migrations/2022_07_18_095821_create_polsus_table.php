<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polsus', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\User::class, "user_id");

            $table->string('nama');
            $table->string('no_ktp');
            $table->string('no_hp');
//            $table->string('jenis_kelamin');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('detail_alamat');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('rt');
            $table->string('rw');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
//            $table->string('agama');

            $table->string("pangkat");
            $table->string("jabatan");
            $table->string("no_nip");
            $table->string("instansi");
            $table->string("jenjang_diklat");
            $table->string("no_ijazah");
            $table->string("tempat_dikeluarkan_ijazah");
            $table->date("tanggal_dikeluarkan_ijazah");
            $table->string('no_kta');
            $table->string("pejabat_yang_mengeluarkan_kta");
            $table->date("expired_kta");
            $table->string("no_izin_pegang_senpi");
            $table->string("pejabat_yang_mengeluarkan_izin_pegang_senpi");
            $table->date("expired_izin_pegang");
            $table->string("foto_profile");
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
        Schema::dropIfExists('polsus');
    }
}
