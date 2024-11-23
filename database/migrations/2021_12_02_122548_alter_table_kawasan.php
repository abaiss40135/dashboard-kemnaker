<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableKawasan extends Migration
{
    public function up()
    {
        Schema::table('kawasan', function (Blueprint $table) {
            $table->foreign('province_code')
                ->references('code')
                ->on('provinces')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('kawasan', function (Blueprint $table) {
            $table->dropForeign('kawasan_province_code_foreign');
        });
    }
}
