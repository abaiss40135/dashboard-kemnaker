<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJmlSdhPelatihanPolmasToPetugasPolmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petugas_polmas', function (Blueprint $table) {
            $table->integer("jumlah_sdh_pelatihan_polmas")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petugas_polmas', function (Blueprint $table) {
            $table->dropColumn("jumlah_sdh_pelatihan_polmas");
        });
    }
}
