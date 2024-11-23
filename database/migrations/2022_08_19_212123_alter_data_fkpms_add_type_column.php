<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDataFkpmsAddTypeColumn extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('data_fkpms', function (Blueprint $table) {
            $table->string('model_kawasan')->change()->nullable();
            $table->string('model_wilayah')->change()->nullable();
            $table->renameColumn('model_wilayah', 'wilayah');
            $table->renameColumn('model_kawasan', 'kawasan');
            $table->string('type', 7)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('data_fkpms', function (Blueprint $table) {
            $table->string('kawasan')->change();
            $table->string('wilayah')->change();
            $table->renameColumn('wilayah', 'model_wilayah');
            $table->renameColumn('kawasan', 'model_kawasan');
            $table->dropColumn('type');
        });

    }
}
