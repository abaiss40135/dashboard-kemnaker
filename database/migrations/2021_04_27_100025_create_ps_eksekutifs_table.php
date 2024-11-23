<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsEksekutifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ps_eksekutifs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->date('tanggal_kejadian');
            $table->time('waktu_kejadian');
            $table->text('lokasi_kejadian');
            $table->string('bidang_masalah');
            $table->text('uraian_kejadian');
            $table->string('keyword');
            $table->string('saksi');
            $table->text('uraian_problem_solving');
            $table->string('pihak_eskalasi_problem_solving');
            $table->string('penulis')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ps_eksekutifs');
    }
}
