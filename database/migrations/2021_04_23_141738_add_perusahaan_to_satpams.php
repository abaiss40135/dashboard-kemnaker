<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerusahaanToSatpams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('satpams', function (Blueprint $table) {
            $table->string('perusahaan' , 400)->after('bujp_id')->nullable();
            $table->unsignedBigInteger('bujp_id')->nullable()->change();
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
            $table->dropColumn(['perusahaan']);
        });
    }
}
