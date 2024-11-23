<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPenyakitMulutKukusAddPoldaPolres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penyakit_mulut_kukus', function (Blueprint $table) {
            $table->string('polda')->nullable();
            $table->string('polres')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penyakit_mulut_kukus', function (Blueprint $table) {
            $table->dropColumn('polda');
            $table->dropColumn('polres');
        });
    }
}
