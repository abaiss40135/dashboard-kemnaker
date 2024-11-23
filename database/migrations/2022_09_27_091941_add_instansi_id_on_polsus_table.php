<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstansiIdOnPolsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('polsus', function(Blueprint $table) {
//            $table->dropColumn('instansi');
//            $table->foreignIdFor(\App\Models\Instansi::class, 'instansi_id')->nullable();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('polsus', function(Blueprint $table) {
//            $table->string('instansi');
//            $table->dropIfExists('instansi_id');
//        });
    }
}
