<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnActiveToKategoriInformasiTable extends Migration
{
    public function up()
    {
        Schema::table('kategori_informasi', function (Blueprint $table) {
            $table->boolean('active')->after('query')->default(true);
        });
    }

    public function down()
    {
        Schema::table('kategori_informasi', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
}
