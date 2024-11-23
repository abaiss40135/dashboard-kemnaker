<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoSkepColumnToPersonelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personel', function (Blueprint $table) {
            $table->string("no_skep")->nullable()->after("jabatan");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personel', function (Blueprint $table) {
            $table->dropColumn("no_skep");
        });
    }
}
