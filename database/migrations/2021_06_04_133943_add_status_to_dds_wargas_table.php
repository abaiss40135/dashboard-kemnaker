<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToDdsWargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->text('status_penerima_kunjungan')->nullable()->default('...');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->dropColumn(['status_penerima_kunjungan']);
        });
    }
}
