<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('file_ds', function (Blueprint $table) {
            $table->dropForeign('file_ds_nib_foreign');

        });
    }

    public function down()
    {
        Schema::table('file_ds', function (Blueprint $table) {
            $table->foreign('nib')
                ->references('nib')
                ->on('bujps');
        });
    }
};
