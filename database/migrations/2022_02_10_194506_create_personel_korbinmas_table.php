<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonelKorbinmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personel_korbinmas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('satker');
            $table->string('bulan');
            $table->integer('irjen_dsp')->default(0);
            $table->integer('irjen_riil')->default(0);
            $table->integer('brigjen_dsp')->default(0);
            $table->integer('brigjen_riil')->default(0);
            $table->integer('kbp_dsp')->default(0);
            $table->integer('kbp_riil')->default(0);
            $table->integer('akbp_dsp')->default(0);
            $table->integer('akbp_riil')->default(0);
            $table->integer('kp_dsp')->default(0);
            $table->integer('kp_riil')->default(0);
            $table->integer('akp_dsp')->default(0);
            $table->integer('akp_riil')->default(0);
            $table->integer('ip_dsp')->default(0);
            $table->integer('ip_riil')->default(0);
            $table->integer('ba_ta_dsp')->default(0);
            $table->integer('ba_ta_riil')->default(0);
            $table->integer('pns_4_dsp')->default(0);
            $table->integer('pns_4_riil')->default(0);
            $table->integer('pns_3_dsp')->default(0);
            $table->integer('pns_3_riil')->default(0);
            $table->integer('pns_1_2_dsp')->default(0);
            $table->integer('pns_1_2_riil')->default(0);
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
        Schema::dropIfExists('personel_korbinmas');
    }
}
