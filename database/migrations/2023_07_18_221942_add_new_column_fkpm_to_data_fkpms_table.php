<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnFkpmToDataFkpmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_fkpms', function (Blueprint $table) {
            $table->string('nama_petugas_polmas')->nullable();
            $table->string('pangkat_petugas_polmas')->nullable();
            $table->string('no_hp_petugas_polmas')->nullable();
            $table->integer('jumlah_anggota_fkpm')->nullable();
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
            $table->dropColumn('nama_petugas_polmas');
            $table->dropColumn('pangkat_petugas_polmas');
            $table->dropColumn('no_hp_petugas_polmas');
            $table->dropColumn('jumlah_anggota_fkpm');
        });
    }
}
