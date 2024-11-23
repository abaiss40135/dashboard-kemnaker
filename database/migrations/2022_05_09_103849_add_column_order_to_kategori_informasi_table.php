<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOrderToKategoriInformasiTable extends Migration
{
    public function up()
    {
        Schema::table('kategori_informasi', function (Blueprint $table) {
            $table->decimal('order', 8, 0)->after('id')->unique()->nullable();
        });
    }

    public function down()
    {
        Schema::table('kategori_informasi', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
}
