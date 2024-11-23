<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanKorwasbintekKoordinasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatan_korwasbintek_koordinasis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id')->constrained()->cascadeOnDelete();
            $table->string('polda');
            $table->string('polres');
            $table->string('bentuk_kegiatan');
            $table->string('jml_kegiatan');
            $table->string('jml_pers_yang_terlibat');
            $table->string('hasil');
            $table->string('kendala');
            $table->string('solusi');
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
        Schema::dropIfExists('kegiatan_korwasbintek_koordinasis');
    }
}
