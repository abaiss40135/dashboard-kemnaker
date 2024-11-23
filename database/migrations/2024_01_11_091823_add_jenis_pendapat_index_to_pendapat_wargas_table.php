<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisPendapatIndexToPendapatWargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendapat_wargas', function (Blueprint $table) {
            $table->index('jenis_pendapat');
            $table->index(['dds_warga_id', 'jenis_pendapat']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendapat_wargas', function (Blueprint $table) {
            $table->dropIndex('jenis_pendapat');
            $table->dropIndex(['dds_warga_id', 'jenis_pendapat']);
        });
    }
}
