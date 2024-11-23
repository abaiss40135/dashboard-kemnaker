<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToLocationTable extends Migration
{
    public function up()
    {
        Schema::table('provinces', function (Blueprint $table) {
            $table->index(['code']);
            $table->index(['name']);
            $table->index(['polda']);
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->index(['code']);
            $table->index(['province_code']);
            $table->index(['name']);
        });
        Schema::table('districts', function (Blueprint $table) {
            $table->index(['code']);
            $table->index(['city_code']);
        });
        Schema::table('villages', function (Blueprint $table) {
            $table->index(['code']);
            $table->index(['district_code']);
            $table->index(['name']);
        });
    }

    public function down()
    {
        Schema::table('provinces', function (Blueprint $table) {
            $table->dropIndex(['code']);
            $table->dropIndex(['name']);
            $table->dropIndex(['polda']);
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->dropIndex(['code']);
            $table->dropIndex(['province_code']);
            $table->dropIndex(['name']);
        });
        Schema::table('districts', function (Blueprint $table) {
            $table->dropIndex(['code']);
            $table->dropIndex(['city_code']);
            $table->dropIndex(['name']);
        });
        Schema::table('villages', function (Blueprint $table) {
            $table->dropIndex(['code']);
            $table->dropIndex(['district_code']);
            $table->dropIndex(['name']);
        });
    }
}
