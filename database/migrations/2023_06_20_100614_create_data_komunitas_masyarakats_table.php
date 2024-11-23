<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKomunitasMasyarakatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_komunitas_masyarakats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('polres');
            $table->string('polda');
            $table->string('nama_kommas');
            $table->string('akta_notaris');
            $table->string('npwp');
            $table->string('sumber_dana');
            $table->string('bidang_kegiatan');
            $table->string('jml_anggota');
            $table->string('alamat');
            $table->string('nama_ketua');
            $table->string('no_hp');
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
        Schema::dropIfExists('data_komunitas_masyarakats');
    }
}
