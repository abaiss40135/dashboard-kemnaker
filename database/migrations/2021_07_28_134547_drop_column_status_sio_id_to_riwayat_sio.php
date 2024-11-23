<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnStatusSioIdToRiwayatSio extends Migration
{
    public function up()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->dropColumn('status_sio_id');
        });
    }

    public function down()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->foreignId('status_sio_id')->constrained();
        });
    }
}
