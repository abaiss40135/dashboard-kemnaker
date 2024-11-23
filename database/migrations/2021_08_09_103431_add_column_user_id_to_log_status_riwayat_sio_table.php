<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUserIdToLogStatusRiwayatSioTable extends Migration
{
    public function up()
    {
        Schema::table('log_status_riwayat_sio', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('role')->nullable();
        });
    }

    public function down()
    {
        Schema::table('log_status_riwayat_sio', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'role']);
        });
    }
}
