<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKerjasamaDitbinmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_kerjasama_ditbinmas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('satker');
            $table->string('mou');
            $table->string('isi');
            $table->string('masa_berlaku');
            $table->string('kode_satuan');
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
        Schema::dropIfExists('data_kerjasama_ditbinmas');
    }
}
