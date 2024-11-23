<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategoriColumnAtDataSenpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_senpi', function (Blueprint $table) {
            $table->string('kategori')->nullable();
            $table->foreignIdFor(\App\Models\Instansi::class);
        });

        if(Schema::hasColumn('data_senpi', 'kategori')) {
            Schema::table('data_senpi', function (Blueprint $table) {
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
        if(Schema::hasColumn('data_senpi', 'kategori')) {
            Schema::table('data_senpi', function (Blueprint $table) {
                $table->dropColumn('kategori');
            });
        }

        if(Schema::gotColumn('data_senpi', 'instansi_id')) {
            Schema::table('data_senpi', function (Blueprint $table) {
                $table->dropColumn('instansi_id');
            });
        }
    }
}
