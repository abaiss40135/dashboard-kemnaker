<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiatLinseksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giat_linseks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kesatuan');
            $table->string('jenis_kegiatan');
            $table->string('materi_pembahasan');
            $table->string('instansi_terlibat');
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
        Schema::dropIfExists('giat_linseks');
    }
}
