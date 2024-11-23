<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDataPerubahanJumlahBhabinkamtibmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_perubahan_jumlah_bhabinkamtibmas', function (Blueprint $table) {
            $table->dropColumn('polsek');
            $table->dropColumn('file_skep');
            $table->dropColumn('no_skep');

            $table->string('file_data_personel_bhabinkamtibmas_polres')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_perubahan_jumlah_bhabinkamtibmas', function (Blueprint $table) {
            $table->string('polsek')->nullable();
            $table->string('file_skep')->nullable();
            $table->string('no_skep');

            $table->dropColumn('file_data_personel_bhabinkamtibmas_polres');
        });
    }
}
