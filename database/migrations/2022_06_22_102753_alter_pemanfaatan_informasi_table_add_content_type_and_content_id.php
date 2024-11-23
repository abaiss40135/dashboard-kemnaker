<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPemanfaatanInformasiTableAddContentTypeAndContentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemanfaatan_informasi', function (Blueprint $table) {
            $table->string('content_type')->nullable();
            $table->unsignedBigInteger('content_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemanfaatan_informasi', function (Blueprint $table) {
            $table->dropColumn('content_type');
            $table->dropColumn('content_id');
        });
    }
}
