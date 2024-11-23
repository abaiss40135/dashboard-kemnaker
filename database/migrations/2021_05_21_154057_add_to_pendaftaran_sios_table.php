<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToPendaftaranSiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            $table->integer('nib')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->text('alamat')->nullable();
            $table->text('jenis_usaha')->nullable();
            $table->string('nama_polda')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            //
        });
    }
}
