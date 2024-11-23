<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMutasiUsersAddForeignIdUserIdPengubah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mutasi_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id_pengubah');
            $table->foreign('user_id_pengubah')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mutasi_users', function (Blueprint $table) {
            $table->dropForeign('user_id_pengubah');
        });
    }
}
