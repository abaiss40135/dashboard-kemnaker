<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('atensi_pimpinan')->nullable();
            $table->integer('atensi_pimpinan_jumlah')->nullable();
            $table->string('infografis')->nullable();
            $table->integer('infografis_jumlah')->nullable();
            $table->string('paparan')->nullable();
            $table->integer('paparan_jumlah')->nullable();
            $table->string('meme')->nullable();
            $table->integer('meme_jumlah')->nullable();
            $table->string('naskah')->nullable();
            $table->integer('naskah_jumlah')->nullable();
            $table->string('undang_undang')->nullable();
            $table->integer('undang_undang_jumlah')->nullable();
            $table->string('peraturan_dalam')->nullable();
            $table->integer('peraturan_dalam_jumlah')->nullable();
            $table->string('peraturan_luar')->nullable();
            $table->integer('peraturan_luar_jumlah')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}