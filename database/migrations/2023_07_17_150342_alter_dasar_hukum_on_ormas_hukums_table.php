<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterDasarHukumOnOrmasHukumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ormas_hukums', function (Blueprint $table) {
            $table->renameColumn('nama_ormas', 'nama_orsosmas');
            $table->date('tanggal')->nullable()->change();
            $table->renameColumn('tanggal', 'tanggal_akta_notaris');
            $table->string('akta_notaris')->nullable()->change();
            $table->string('no_skt_kemendagri')->nullable()->change();
            $table->renameColumn('no_skt_kemendagri', 'dasar_hukum');
            $table->date('tanggal_dasar_hukum')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ormas_hukums', function (Blueprint $table) {
            $table->renameColumn('nama_orsosmas', 'nama_ormas');
            $table->date('tanggal_akta_notaris')->nullable(false)->change();
            $table->renameColumn('tanggal_akta_notaris', 'tanggal');
            $table->string('akta_notaris')->nullable(false)->change();
            $table->string('dasar_hukum')->nullable(false)->change();
            $table->renameColumn('dasar_hukum', 'no_skt_kemendagri');
            $table->dropColumn('tanggal_dasar_hukum');
        });
    }
}
