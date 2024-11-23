<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProblemSolvingsRenameColumn extends Migration
{
    public function up()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->renameColumn('tanggal_kejadian', 'tanggal');
        });
    }

    public function down()
    {
        Schema::table('problem_solvings', function (Blueprint $table) {
            $table->renameColumn('tanggal', 'tanggal_kejadian');
        });
    }
}
