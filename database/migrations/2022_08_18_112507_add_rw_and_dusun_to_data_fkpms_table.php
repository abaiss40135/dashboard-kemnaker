<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRwAndDusunToDataFkpmsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('data_fkpms', function (Blueprint $table) {
            if (!Schema::hasColumn('data_fkpms', 'model_kawasan')) {
                $table->string('model_kawasan')->nullable();
            }
            if (!Schema::hasColumn('data_fkpms', 'model_wilayah')) {
                $table->string('model_wilayah')->nullable();
            }
            if (!Schema::hasColumn('data_fkpms', 'polda')) {
                $table->string('polda')->nullable();
            }
            if (!Schema::hasColumn('data_fkpms', 'polres')) {
                $table->string('polres')->nullable();
            }
            if (!Schema::hasColumn('data_fkpms', 'rw')) {
                $table->string('rw')->nullable();
            }
            if (!Schema::hasColumn('data_fkpms', 'dusun')) {
                $table->string('dusun')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('data_fkpms', function (Blueprint $table) {
            $table->dropColumn('model_kawasan');
            $table->dropColumn('model_wilayah');
            $table->dropColumn('polda');
            $table->dropColumn('polres');
            $table->dropColumn('rw');
            $table->dropColumn('dusun');
        });
    }
}
