<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsToNullableSatpamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('satpams', function (Blueprint $table) {
            $table->string('no_kta')->nullable()->change();
            $table->string('tanggal_terbit_kta')->nullable()->change();
            $table->string('no_reg')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('satpams', function (Blueprint $table) {
            $table->string('no_kta')->nullable(false)->change();
            $table->string('tanggal_terbit_kta')->nullable(false)->change();
            $table->string('no_reg')->nullable(false)->change();
        });
    }
}
