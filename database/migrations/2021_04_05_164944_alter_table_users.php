<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama')->nullable()->change();
            $table->renameColumn('nama', 'nrp');

            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->dropColumn(['bujp', 'administrator', 'satpam']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nrp')->nullable(false)->change();
            $table->renameColumn('nrp', 'nama');
            $table->dropColumn(['email', 'email_verified_at', 'last_login_at']);
            $table->boolean('bujp')->nullable();
            $table->boolean('administrator')->nullable();
            $table->boolean('satpam')->nullable();
        });
    }
}
