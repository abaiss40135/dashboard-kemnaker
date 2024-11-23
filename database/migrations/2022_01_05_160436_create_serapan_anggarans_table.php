<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSerapanAnggaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serapan_anggarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode');
            $table->string('program');
            $table->string('bulan');
            $table->integer('pagu')->default(0);
            $table->integer('realisasi')->default(0);
            $table->integer('presentase')->default(0);
            $table->integer('sisa')->default(0);
            $table->integer('pnbp_pagu')->default(0);
            $table->integer('pnbp_realisasi')->default(0);
            $table->integer('pnbp_presentase')->default(0);
            $table->integer('pnbp_sisa')->default(0);
            $table->string('hambatan')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->string('kode_satuan');
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
        Schema::dropIfExists('serapan_anggarans');
    }
}
