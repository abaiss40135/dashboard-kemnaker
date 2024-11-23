<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropOldRegionTable extends Migration
{
    public function up()
    {
        DB::statement('DROP TABLE if exists indonesia_villages cascade ;');
        DB::statement('DROP TABLE if exists indonesia_districts cascade ;');
        DB::statement('DROP TABLE if exists indonesia_cities cascade ;');
        DB::statement('DROP TABLE if exists indonesia_provinces cascade ;');
    }

    public function down()
    {

    }
}
