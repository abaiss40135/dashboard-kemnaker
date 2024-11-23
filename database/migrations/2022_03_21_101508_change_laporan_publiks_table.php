<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeLaporanPubliksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_publiks', function(Blueprint $table) {
            $table->dropColumn(['uraian', 'penulis']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->date('tanggal_dapat_informasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_publiks', function(Blueprint $table) {
            $table->dropColumn(['user_id', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'rt', 'rw', 'tanggal_dapat_informasi']);
            $table->text('uraian')->nullable();
            $table->string('penulis')->nullable();
        });
    }
}
