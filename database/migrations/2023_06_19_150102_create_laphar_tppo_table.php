<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapharTppoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laphar_tppo', function (Blueprint $table) {
            $table->id();
            $table->string('polda');
            $table->string('polres');
            $table->integer('tatap_muka')->default(0);
            $table->integer('media_cetak')->default(0);
            $table->integer('media_sosial')->default(0);
            $table->integer('binluh')->default(0);
            $table->integer('koordinasi_p3mi')->default(0);
            $table->integer('koordinasi_dinas')->default(0);
            $table->integer('workshop')->default(0);
            $table->string('kode_satuan');
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
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
        Schema::dropIfExists('laphar_tppo');
    }
}
