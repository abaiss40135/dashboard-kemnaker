<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeAttributeToPolsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('polsus', function (Blueprint $table) {
//            if (!Schema::hasColumn('polsus', 'golongan')) {
//                $table->string("golongan")->nullable();
//            }
//            if (!Schema::hasColumn('polsus', 'jenis_polsus')) {
//                $table->string("jenis_polsus")->nullable();
//            }
//            if (!Schema::hasColumn('polsus', 'kepemilikan_kta')) {
//                $table->string("kepemilikan_kta")->nullable();
//            }
//            if (!Schema::hasColumn('polsus', 'no_kta')) {
//                $table->string("no_kta")->nullable();
//            }
//            if (!Schema::hasColumn('polsus', 'pejabat_yang_mengeluarkan_kta')) {
//                $table->string("pejabat_yang_mengeluarkan_kta")->nullable();
//            }
//            if (!Schema::hasColumn('polsus', 'expired_kta')) {
//                $table->string("expired_kta")->nullable();
//            }
//            if (!Schema::hasColumn('polsus', 'no_skep')) {
//                $table->string("no_skep")->nullable();
//            }
//            if (!Schema::hasColumn('polsus', 'kelengkapan_perorangan')) {
//                $table->string("kelengkapan_perorangan")->nullable();
//            }
//
//            if (Schema::hasColumn('polsus', 'no_ktp')) {
//                $table->dropColumn('no_ktp');
//            }
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
//            $table->dropColumn("golongan");
//            $table->dropColumn('jenis_polsus');
//
//            $table->dropColumn('kepemilikan_kta');
//            $table->dropColumn('no_kta');
//            $table->dropColumn("pejabat_yang_mengeluarkan_kta");
//            $table->dropColumn("expired_kta");
//            $table->dropColumn("no_skep");
//            $table->dropColumn("kelengkapan_perorangan");
//
//            $table->integer('no_ktp')->nullable();
//        });
    }
}
