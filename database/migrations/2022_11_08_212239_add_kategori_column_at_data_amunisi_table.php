<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategoriColumnAtDataAmunisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_amunisi', function (Blueprint $table) {
            $table->string('kategori')->nullable();
            $table->foreignIdFor(\App\Models\Instansi::class);
        });

        if(Schema::hasColumn('data_amunisi', 'kategori')) {
            Schema::table('data_amunisi', function (Blueprint $table) {
                $table->dropColumn('instansi');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('data_amunisi', 'kategori')) {
            Schema::table('data_amunisi', function (Blueprint $table) {
                $table->dropColumn('kategori');
            });
        }

        if(Schema::hasColumn('data_amunisi', 'instansi_id')) {
            Schema::table('data_amunisi', function (Blueprint $table) {
                $table->dropColumn('instansi_id');
            });
        }
    }
}
