<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPemanfaatanInformasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemanfaatan_informasi', function (Blueprint $table) {
            $table->dropColumn('jenis_pemanfaatan');
            $table->dropColumn('personel_id');
            $table->dropColumn('kode_satuan');
            $table->dropColumn('jenis_informasi');
            $table->dropColumn('informasi_id');
            $table->integer('download')->default(0);
            $table->integer('copy_link')->default(0);
            $table->string('bulan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemanfaatan_informasi', function (Blueprint $table) {
            $table->dropColumn('download');
            $table->dropColumn('copy_link');
            $table->dropColumn('bulan');
        });
    }
}
