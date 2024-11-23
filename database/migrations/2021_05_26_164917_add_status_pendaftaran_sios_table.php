<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPendaftaranSiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_sios' , function(Blueprint $table){
            $table->unsignedBigInteger('status')->nullable()->default(1);
            $table->foreign('status')
                  ->references('id')
                  ->on('status_sios')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran_sios', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}
