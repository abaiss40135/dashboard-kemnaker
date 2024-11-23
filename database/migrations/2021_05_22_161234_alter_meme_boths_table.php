<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMemeBothsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meme_boths', function(Blueprint $table)
        {
            $table->text('caption')->change();
            $table->text('file')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meme_boths', function(Blueprint $table)
        {
            $table->string('caption', 2000)->change();
            $table->string('file', 2000)->change();
        });
    }
}
