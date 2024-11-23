<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableBeritasAddLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beritas' , function(Blueprint $table){
            $table->string('judul')->nullable()->change();
            $table->string('tanggal_dibuat')->nullable()->change();
            $table->string('isi_berita' , 4000)->nullable()->change();
            $table->string('pembuat_berita' , 255)->nullable()->change();
            $table->string('gambar')->nullable()->change();
            $table->string('link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beritas' , function(Blueprint $table){
            $table->dropColumn('link');
        });
    }
}
