<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDdsWargasTableChangeAlamatColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dds_wargas', function(Blueprint $table) {
            $table->text('detail_alamat_kepala_keluarga')->change();
            $table->text('detail_alamat_keluarga_bukan_serumah')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dds_wargas', function(Blueprint $table) {
            $table->string('detail_alamat_kepala_keluarga')->change();
            $table->string('detail_alamat_keluarga_bukan_serumah')->change();
        });
    }
}
