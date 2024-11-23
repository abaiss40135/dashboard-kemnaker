<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapharDitbinmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laphar_ditbinmas', function (Blueprint $table) {
            $table->id();
            $table->string('polda');
            $table->string('satker');
            $table->integer('binluh');
            $table->integer('sambang');
            $table->integer('penmas');
            $table->integer('ps');
            $table->integer('pendampingan_dana_desa');
            $table->integer('pembuatan_li');
            $table->integer('keagamaan');

            $table->string('kode_satuan');
            $table->foreignIdFor(User::class, 'user_id');
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
        Schema::dropIfExists('laphar_ditbinmas');
    }
}
