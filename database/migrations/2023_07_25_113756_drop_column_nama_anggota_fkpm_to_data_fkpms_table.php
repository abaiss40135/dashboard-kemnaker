<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnNamaAnggotaFkpmToDataFkpmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_fkpms', function (Blueprint $table) {
            $table->dropColumn('nama_anggota_fkpm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_fkpms', function (Blueprint $table) {
            $table->string('nama_anggota_fkpm');
        });
    }
}
