<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSatpamsTableDropPerusahaanAddJenjangPelatihan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('satpams', function (Blueprint $table) {
            $table->dropColumn(['perusahaan']);
            $table->string('jenjang_pelatihan')->nullable();
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
            $table->string('perusahaan')->nullable();
            $table->dropColumn(['jenjang_pelatihan']);
        });
    }
}
