<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBujpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bujps', function (Blueprint $table) {
            $table->string('nib')->nullable();
            $table->string('website_badan_usaha')->nullable()->change();
            $table->string('panggilan_penanggung_jawab')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bujps', function (Blueprint $table) {
            $table->dropColumn('nib');
            $table->string('website_badan_usaha')->change();
            $table->string('panggilan_penanggung_jawab')->nullable();
        });
    }
}
