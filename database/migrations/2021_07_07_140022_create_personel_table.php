<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonelTable extends Migration
{
    public function up()
    {
        Schema::create('personel', function (Blueprint $table) {
            $table->integer('personel_id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->string('nama', 191)->nullable();
            $table->string('pangkat', 191)->nullable();
            $table->string('jabatan', 191)->nullable();
            $table->string('keterangan_tambahan', 191)->nullable();
            $table->date('tmt_jabatan');
            $table->string('lama_jabatan', 191)->nullable();
            $table->string('satuan', 191)->nullable();
            $table->string('handphone', 191)->nullable();
            $table->string('jenis_kelamin', 191)->nullable();
            $table->date('tanggal_lahir');
            $table->string('email', 191)->nullable();
            $table->string('email_dinas', 191)->nullable();
            $table->string('satuan1', 191)->nullable();
            $table->string('satuan2', 191)->nullable();
            $table->string('satuan3', 191)->nullable();
            $table->string('satuan4', 191)->nullable();
            $table->string('satuan5', 191)->nullable();
            $table->string('satuan6', 191)->nullable();
            $table->string('satuan7', 191)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('personel');
    }
}
