<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsTypeLapharPcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laphar_pcs', function (Blueprint $table) {
            $table->string('perbelanjaan')->change();
            $table->string('perkantoran')->change();
            $table->string('pemukiman')->change();
            $table->string('kawasan')->change();
            $table->string('transportasi_publik')->change();
            $table->string('tempat_wisata')->change();
            $table->string('komunitas_hobi')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laphar_pcs', function (Blueprint $table) {
            $table->integer('perbelanjaan')->change();
            $table->integer('perkantoran')->change();
            $table->integer('pemukiman')->change();
            $table->integer('kawasan')->change();
            $table->integer('transportasi_publik')->change();
            $table->integer('tempat_wisata')->change();
            $table->integer('komunitas_hobi')->change();
        });
    }
}
