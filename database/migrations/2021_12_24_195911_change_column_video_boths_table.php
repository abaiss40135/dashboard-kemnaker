<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnVideoBothsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_boths', function (Blueprint $table) {
            $table->integer('status')->nullable()->default(0)->change();
            $table->dropColumn('sended');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_boths', function (Blueprint $table) {
            $table->integer('status')->nullable()->default(0)->change();
            $table->integer('sended')->nullable()->default(0);
        });
    }
}
