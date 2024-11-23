<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSislapSatkamlingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sislap_satkamling', function (Blueprint $table) {
            $table->id();
            $table->string('polda');
            $table->integer('satkamling_aktif');
            $table->integer('satkamling_pasif');
            $table->integer('satkamling_jumlah');
            $table->integer('revitalisasi_baru');
            $table->integer('revitalisasi_lama');
            $table->integer('revitalisasi_jumlah');
            $table->foreignIdFor(User::class, 'user_id');
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
        Schema::dropIfExists('sislap_satkamling');
    }
}
