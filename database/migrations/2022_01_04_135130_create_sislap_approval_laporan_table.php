<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSislapApprovalLaporanTable extends Migration
{
    public function up()
    {
        Schema::create('sislap_approval_laporan', function (Blueprint $table) {
            $table->bigIncrements('id');
            /**
             * NULL     = DIAJUKAN
             * FALSE    = UNAPPROVE
             * TRUE     = APPROVE
             */
            $table->boolean('is_approve')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('approver')->nullable();
            $table->foreign('approver')
                ->references('id')
                ->on('users');
            $table->morphs('approvable');
            /**
             * polres, polda, mabes
             */
            $table->string('level', 6);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sislap_approval_laporan');
    }
}
