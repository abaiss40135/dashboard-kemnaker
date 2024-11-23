<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueIdIzinToDataChecklistTable extends Migration
{
    public function up()
    {
        Schema::table('data_checklist', function (Blueprint $table) {
            $table->unique('id_izin');
        });
    }

    public function down()
    {
        Schema::table('data_checklist', function (Blueprint $table) {
            $table->dropUnique('data_checklist_id_izin_unique');
        });
    }
}
