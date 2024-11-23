<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtensiPimpinansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atensi_pimpinans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('judul_atensi' , 255);
            $table->string('pemberi_atensi' , 255);
            $table->string('isi_atensi' , 10000);
            $table->string('tanggal_atensi', 255);
            $table->integer('notification')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atensi_pimpinans');
    }
}