<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

class AlterLokasiPenugasansTable extends Migration
{
    public function up()
    {
        if (!Type::hasType('char')) {
            Type::addType('char', StringType::class);
        }
        Schema::table('lokasi_penugasans', function (Blueprint $table) {
            $table->char('kecamatan_code')->nullable()->change();
            $table->char('desa_code')->nullable()->change();

            $table->char('kawasan')->nullable();
            $table->string('jenis_lokasi', 10);
        });
    }

    public function down()
    {
        Schema::table('lokasi_penugasans', function (Blueprint $table) {
            $table->char('kecamatan_code')->nullable(false)->change();
            $table->char('desa_code')->nullable(false)->change();

            $table->dropColumn(['kawasan', 'jenis_lokasi']);
        });
    }
}
