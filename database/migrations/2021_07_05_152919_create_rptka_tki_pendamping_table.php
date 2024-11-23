<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRptkaTkiPendampingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rptka_tki_pendamping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rptka_jabatan_id');
            $table->foreign('rptka_jabatan_id')
                ->references('id')
                ->on('rptka_jabatan')
                ->onDelete('cascade');

            $table->integer('id_jabatan',false)->nullable();
            $table->integer('id_pendamping',false)->nullable();
            $table->string('nama',100)->nullable();
            $table->string('nik',20)->nullable();
            $table->string('jabatan',255)->nullable();
            $table->string('hp',25)->nullable();
            $table->string('email',100)->nullable();
            $table->string('foto',65535)->nullable();
            $table->string('pendidikan_min',50)->nullable();
            $table->string('sertifikat',255)->nullable();
            $table->double('pengalaman_kerja',11)->nullable();
            $table->string('keterangan',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rptka_tki_pendamping');
    }
}
