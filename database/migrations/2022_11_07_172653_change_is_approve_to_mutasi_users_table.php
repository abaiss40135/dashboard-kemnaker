<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('mutasi_users', function (Blueprint $table) {
            $table->boolean('is_approve')->nullable();
            $table->unsignedBigInteger('approver')->nullable();
            $table->foreign('approver')->references('id')->on('users');
            $table->text('note')->nullable();
        });
    }

    public function down()
    {
        Schema::table('mutasi_users', function (Blueprint $table) {
            $table->dropColumn(['is_approve', 'approver', 'note']);
        });
    }
};
