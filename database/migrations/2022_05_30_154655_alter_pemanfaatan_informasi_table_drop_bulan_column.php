<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPemanfaatanInformasiTableDropBulanColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemanfaatan_informasi', function (Blueprint $table) {
            $table->dropColumn('bulan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemanfaatan_informasi', function (Blueprint $table) {
            $table->string('bulan');
        });
    }
}
