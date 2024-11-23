<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

class AlterLokasiPenugasansTableChangeLength extends Migration
{
    public function up()
    {
        if (!Type::hasType('char')) {
            Type::addType('char', StringType::class);
        }
        Schema::table('lokasi_penugasans', function (Blueprint $table) {
            $table->char('province_code', 2)->change();
            $table->char('city_code', 4)->change();
            $table->char('district_code', 7)->change();
            $table->char('village_code', 10)->change();
        });
    }

    public function down()
    {
        Schema::table('lokasi_penugasans', function (Blueprint $table) {
            //
        });
    }
}
