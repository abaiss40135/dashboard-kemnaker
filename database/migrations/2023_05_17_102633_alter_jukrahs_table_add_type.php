<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterJukrahsTableAddType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jukrahs', function (Blueprint $table) {
            $table->renameColumn('nama_jukrah', 'nama');
            $table->renameColumn('file_jukrah', 'file');
            $table->string('type')->default('bhabinkamtibmas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jukrahs', function (Blueprint $table) {
            //
        });
    }
}
