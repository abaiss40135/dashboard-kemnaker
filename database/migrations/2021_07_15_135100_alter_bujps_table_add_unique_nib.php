<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBujpsTableAddUniqueNib extends Migration
{
    public function up()
    {
        Schema::table('bujps', function (Blueprint $table) {
            $table->unique('nib');
        });
    }

    public function down()
    {
        Schema::table('bujps', function (Blueprint $table) {
            $table->dropUnique('bujps_nib_unique');
        });
    }
}
