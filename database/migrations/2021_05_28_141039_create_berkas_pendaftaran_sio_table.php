
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasPendaftaranSioTable extends Migration
{
    public function up()
    {
        Schema::create('berkas_pendaftaran_sio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pendaftaran_sio_id');
            $table->foreign('pendaftaran_sio_id')
                ->references('id')
                ->on('pendaftaran_sios')
                ->cascadeOnDelete();
            $table->string('nama');
            $table->text('file');

            $table->string('jenis_berkas');
            $table->foreign('jenis_berkas')
                ->references('jenis')
                ->on('jenis_berkas');

            $table->boolean('validasi')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berkas_pendaftaran_sio');
    }
}
