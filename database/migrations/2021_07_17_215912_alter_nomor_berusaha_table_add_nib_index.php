<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNomorBerusahaTableAddNibIndex extends Migration
{
    public function up()
    {
        Schema::table('nomor_induk_berusaha', function (Blueprint $table) {
            $table->index('nib');
        });
    }

    public function down()
    {
        Schema::table('nomor_induk_berusaha', function (Blueprint $table) {
            $table->dropIndex('nomor_induk_berusaha_nib_index');
        });
    }
}
