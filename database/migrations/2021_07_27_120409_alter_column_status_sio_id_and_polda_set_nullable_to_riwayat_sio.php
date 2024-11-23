<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnStatusSioIdAndPoldaSetNullableToRiwayatSio extends Migration
{
    public function up()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->unsignedBigInteger('status_sio_id')->nullable()->change();
            $table->string('polda')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('riwayat_sio', function (Blueprint $table) {
            $table->unsignedBigInteger('status_sio_id')->nullable(false)->change();
            $table->string('polda')->nullable(false)->change();
        });
    }
}
