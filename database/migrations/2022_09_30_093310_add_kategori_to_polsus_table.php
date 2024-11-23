<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategoriToPolsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('polsus', function (Blueprint $table) {
            if(!Schema::hasColumn('polsus', 'kategori')) {
                $table->string('kategori')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polsus', function (Blueprint $table) {
            if(Schema::hasColumn('polsus', 'kategori')) {
                $table->dropColumn('kategori');
            }
        });
    }
}
