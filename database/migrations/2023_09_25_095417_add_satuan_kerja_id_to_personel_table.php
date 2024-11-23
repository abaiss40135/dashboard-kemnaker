<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSatuanKerjaIdToPersonelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personel', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\SatuanKerja::class, 'satuan_kerja_id')
                ->nullable()
                ->constrained('satuan_kerja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personel', function (Blueprint $table) {
            //
        });
    }
}
