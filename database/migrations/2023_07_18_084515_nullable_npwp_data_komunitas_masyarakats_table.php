<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableNpwpDataKomunitasMasyarakatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data_komunitas_masyarakats', function (Blueprint $table) {
            $table->date('tanggal_akta_notaris')->nullable();
            $table->bigInteger('provinsi_code')->nullable();
            $table->bigInteger('kabupaten_code')->nullable();
            $table->bigInteger('kecamatan_code')->nullable();
            $table->bigInteger('desa_code')->nullable();
            $table->string('jalan')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();

            $table->renameColumn('no_hp', 'no_hp_ketua')->change();

            $table->string('akta_notaris')->nullable()->change();
            $table->string('npwp')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_komunitas_masyarakats', function (Blueprint $table) {
            $table->dropColumn('tanggal_akta_notaris');
            $table->dropColumn('provinsi_code');
            $table->dropColumn('kabupaten_code');
            $table->dropColumn('kecamatan_code');
            $table->dropColumn('desa_code');
            $table->dropColumn('jalan');
            $table->dropColumn('rt');
            $table->dropColumn('rw');

            $table->renameColumn('no_hp_ketua', 'no_hp')->change();

            $table->string('akta_notaris')->nullable(false)->change();
            $table->string('npwp')->nullable(false)->change();
        });
    }
}