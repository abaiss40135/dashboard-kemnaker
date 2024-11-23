<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddNullableCulumnToPolsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('polsus', function (Blueprint $table) {
//            if (!Schema::hasColumn('polsus', 'memiliki_izin_senpi_amunisi')) {
//                $table->integer("memiliki_izin_senpi_amunisi")->nullable();
//                $table->string("no_izin_pegang_senpi")->nullable()->change();
//                $table->string("pejabat_yang_mengeluarkan_izin_pegang_senpi")->nullable()->change();
//                $table->date("expired_izin_pegang")->nullable()->change();
//            }
//
//            $table->string('no_ijazah')->nullable()->change();
//            $table->string("tempat_dikeluarkan_ijazah")->nullable()->change();
//            $table->date("tanggal_dikeluarkan_ijazah")->nullable()->change();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('polsus', function (Blueprint $table) {
//            if (Schema::hasColumn('polsus', 'memiliki_izin_senpi_amunisi')) {
//                $table->dropColumn("memiliki_izin_senpi_amunisi");
//
//                $table->string("no_izin_pegang_senpi")->change();
//                $table->string("pejabat_yang_mengeluarkan_izin_pegang_senpi")->change();
//                $table->date("expired_izin_pegang")->change();
//            }
//
//            $table->string("no_ijazah")->change();
//            $table->string("tempat_dikeluarkan_ijazah")->change();
//            $table->date("tanggal_dikeluarkan_ijazah")->change();
//        });
    }
}
