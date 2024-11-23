<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTanggalLahirIntoDateTypeToPolsusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('polsus', function (Blueprint $table) {
            if(Schema::hasColumn('tanggal_lahir', 'tanggal_lahir')) {
                Schema::dropColumns('polsus', 'tanggal_lahir');
                $table->date('tanggal_lahir')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polsus', function (Blueprint $table) {
            if(Schema::hasColumn('tanggal_lahir', 'tanggal_lahir')) {
                Schema::dropColumns('polsus', 'tanggal_lahir');
                $table->string('tanggal_lahir')->nullable();
            }
        });
    }
}
