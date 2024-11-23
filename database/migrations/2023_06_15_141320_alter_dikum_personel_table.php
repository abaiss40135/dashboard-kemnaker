<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDikumPersonelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dikum_personel', function (Blueprint $table) {
            $table->decimal('nilai_akhir', 13, 2)->nullable()->change();
            $table->string('nama_institusi', 160)->nullable()->change();
            $table->string('surat_kelulusan_nomor', 128)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
