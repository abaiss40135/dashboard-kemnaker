<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableKeywordsChangeTanggalToDate extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE keywords ALTER COLUMN tanggal TYPE date USING (tanggal::date)');
    }

    public function down()
    {
        Schema::table('keywords', function (Blueprint $table) {
            $table->string('tanggal')->change();
        });
    }
}
