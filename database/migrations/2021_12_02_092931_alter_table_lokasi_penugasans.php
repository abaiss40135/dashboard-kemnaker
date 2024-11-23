<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

class AlterTableLokasiPenugasans extends Migration
{
    public function up()
    {
        if (!Type::hasType('char')) {
            Type::addType('char', StringType::class);
        }
        Schema::table('lokasi_penugasans', function (Blueprint $table) {
            $table->char('city_code')->nullable(true)->change();
        });
    }

    public function down()
    {
        if (!Type::hasType('char')) {
            Type::addType('char', StringType::class);
        }
        Schema::table('lokasi_penugasans', function (Blueprint $table) {
            $table->char('city_code', 4)->change();
        });
    }
}
