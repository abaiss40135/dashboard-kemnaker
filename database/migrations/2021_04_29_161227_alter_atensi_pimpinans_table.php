<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAtensiPimpinansTable extends Migration
{
    public function up()
    {
        Schema::table('atensi_pimpinans', function (Blueprint $table) {
            $table->renameColumn('judul_atensi', 'judul');
            $table->renameColumn('pemberi_atensi', 'pemberi');
            $table->renameColumn('isi_atensi', 'isi');
            $table->dropColumn('tanggal_atensi');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::table('atensi_pimpinans', function (Blueprint $table) {
            $table->dateTime('tanggal')->nullable();
            $table->string('sasaran', 20)->nullable();
        });
    }

    public function down()
    {
        Schema::table('atensi_pimpinans', function (Blueprint $table) {
            $table->renameColumn('judul', 'judul_atensi');
            $table->renameColumn('pemberi', 'pemberi_atensi');
            $table->renameColumn('isi', 'isi_atensi');
            $table->dropColumn(['created_by', 'tanggal', 'sasaran']);
        });

        Schema::table('atensi_pimpinans', function (Blueprint $table) {
            $table->string('tanggal_atensi')->nullable();
        });
    }
}
