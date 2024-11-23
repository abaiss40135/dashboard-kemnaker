<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpsDamaiCartenzsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ops_damai_cartenzs', function (Blueprint $table) {
            $table->id();
            $table->string('daops', 50);
            $table->string('satgas', 50);
            $table->string('jam', 50);
            $table->string('kuat_pers');
            $table->string('lokasi');
            $table->string('kegiatan');
            $table->string('hasil');
            $table->string('keterangan');
            $table->string('type', 50);
            $table->string('kode_satuan', 8);
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
        Schema::dropIfExists('ops_damai_cartenzs');
    }
}
