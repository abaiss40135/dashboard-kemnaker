<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenagaPengamanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenaga_pengamanans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->foreignIdFor(\App\Models\Bujp::class, 'bujp_id');
            $table->string('no_sio');
            $table->string('pengguna_jasa');
            $table->integer('kualifikasi_gp')->default(0);
            $table->integer('kualifikasi_gm')->default(0);
            $table->integer('kualifikasi_gu')->default(0);
            $table->integer('perumahan')->default(0);
            $table->integer('hotel')->default(0);
            $table->integer('rumah_sakit')->default(0);
            $table->integer('perbankan')->default(0);
            $table->integer('pabrik')->default(0);
            $table->integer('toko')->default(0);
            $table->integer('perkebunan')->default(0);
            $table->integer('tambang')->default(0);
            $table->integer('kantor')->default(0);
            $table->integer('transportasi')->default(0);
            $table->integer('pendidikan')->default(0);
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
        Schema::dropIfExists('tenaga_pengamanans');
    }
}
