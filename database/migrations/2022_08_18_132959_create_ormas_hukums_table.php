<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrmasHukumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ormas_hukums');
        Schema::create('ormas_hukums', function (Blueprint $table) {
            $table->id();
            $table->string("tipe");
            $table->string('polda');
            $table->string('polres');
            $table->string("nama_ormas");
            $table->string("no_skt_kemendagri");
            $table->date("tanggal");
            $table->string("akta_notaris");
            $table->string("npwp");
            $table->string("alamat");
            $table->string("sumber_dana");
            $table->string("bidang_kegiatan");
            $table->integer("jml_anggota");
            $table->string("nama_ketua");
            $table->string("no_hp");
            $table->string('kode_satuan');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ormas_hukums');
    }
}
