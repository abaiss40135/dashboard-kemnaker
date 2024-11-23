<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapharTracingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laphar_tracings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_polres');
            $table->integer('jumlah_pasien');
            $table->integer('tracing_pasien_sudah_sembuh');
            $table->integer('tracing_pasien_sudah_md');
            $table->integer('tracing_pasien_tanpa_alamat');
            $table->integer('tracing_pasien_domisi_luar_daerah');
            $table->integer('tracing_pasien_isoman');
            $table->integer('tracing_pasien_isoter');
            $table->integer('tracing_pasien_rawat_inap');
            $table->integer('jumlah_kontak_erat');
            $table->integer('tracing_kontak_erat_sehat');
            $table->integer('tracing_kontak_erat_isoman');
            $table->integer('tracing_kontak_erat_isoter');
            $table->integer('tracing_kontak_erat_dirawat');
            $table->integer('tracing_kontak_erat_tanpa_alamat');
            $table->integer('tracing_kontak_erat_domisili_luar_daerah');
            $table->integer('dll');
            $table->string('keterangan');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('laphar_tracings');
    }
}
