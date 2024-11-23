<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRptkaJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rptka_jabatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rptka_id');
            $table->foreign('rptka_id')
                ->references('id')
                ->on('data_rptka')
                ->onDelete('cascade');

            $table->integer('id_jabatan', false)->nullable();
            $table->string('jabatan',255)->nullable();
            $table->decimal('jumlah',11, 0)->nullable();
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
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
        Schema::dropIfExists('rptka_jabatan');
    }
}
