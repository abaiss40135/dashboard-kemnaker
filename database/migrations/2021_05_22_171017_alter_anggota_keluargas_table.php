<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAnggotaKeluargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anggota_keluargas', function(Blueprint $table)
        {
            $table->string('nama')->nullable()->change();
            $table->string('jenis_kelamin')->nullable()->change();
            $table->string('hubungan')->nullable()->change();
            $table->string('nomor_telepon')->nullable()->change();
            $table->string('tempat_lahir')->nullable()->change();
            $table->string('tanggal_lahir')->nullable()->change();
            $table->string('status_pekerjaan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Scheme::table('anggota_keluargas', function (Blueprint $table)
        {
            $table->string('nama')->change();
            $table->string('jenis_kelamin')->change();
            $table->string('hubungan')->change();
            $table->string('nomor_telepon')->change();
            $table->string('tempat_lahir')->change();
            $table->string('tanggal_lahir')->change();
            $table->string('status_pekerjaan')->change();
        });
    }
}
