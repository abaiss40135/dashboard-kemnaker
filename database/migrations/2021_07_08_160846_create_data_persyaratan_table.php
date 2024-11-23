<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPersyaratanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_persyaratan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_checklist_id');
            $table->foreign('data_checklist_id')
                ->references('id')
                ->on('data_checklist')
                ->onDelete('cascade');

            $table->string('id_syarat',25)->nullable();
            $table->string('no_dokumen',50)->nullable();
            $table->string('tgl_dokumen', 8)->nullable();
            $table->string('file_dokumen',65535)->nullable();
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
        Schema::dropIfExists('data_persyaratan');
    }
}
