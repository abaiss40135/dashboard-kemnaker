<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPensiunAtPolsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        !Schema::hasColumn('polsus', 'status_pensiun') && Schema::table('polsus', function (Blueprint $table) {
            $table->integer('status_pensiun')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::hasColumn('polsus', 'status_pensiun') && Schema::table('polsus', function (Blueprint $table) {
            $table->dropColumn('status_pensiun');
        });
    }
}
