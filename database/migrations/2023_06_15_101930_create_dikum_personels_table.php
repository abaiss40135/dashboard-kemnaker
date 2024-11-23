<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDikumPersonelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dikum_personel', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->string('tingkat', 16);
            $table->string('nama_institusi', 128)->nullable();
            $table->decimal('nilai_akhir')->nullable();
            $table->boolean('dinas');
            $table->string('akreditasi', 16)->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_lulus')->nullable();
            $table->string('jurusan', 64)->nullable();
            $table->string('konsentrasi', 64)->nullable();
            $table->unsignedTinyInteger('ranking')->nullable();
            $table->string('surat_kelulusan_nomor', 64)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dikum_personel');
    }
}
