<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('atensi_pimpinans', function (Blueprint $table) {
            $table->dropColumn(['notification', 'tanggal']);
            $table->index(['sasaran']);
        });
    }

    public function down()
    {
        Schema::table('atensi_pimpinans', function (Blueprint $table) {
            $table->integer('notification')->default(0);
            $table->timestamp('tanggal')->nullable();
            $table->dropIndex(['sasaran']);
        });
    }
};
