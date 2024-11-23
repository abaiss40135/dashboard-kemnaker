<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDdsWargasRenameColumn extends Migration
{
    public function up()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->text('tanggal_kunjungan')->default(null)->nullable(true)->change();
            $table->renameColumn('tanggal_kunjungan', 'tanggal');
        });
        DB::statement("ALTER TABLE dds_wargas ALTER COLUMN tanggal TYPE DATE using to_date(tanggal, 'YYYY-MM-DD')");
    }

    public function down()
    {
        Schema::table('dds_wargas', function (Blueprint $table) {
            $table->text('tanggal')->change();
            $table->renameColumn('tanggal', 'tanggal_kunjungan');
        });
    }
}
