<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataProyekProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_proyek_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_proyek_id');
            $table->foreign('data_proyek_id')
                ->references('id')
                ->on('data_proyek')
                ->onDelete('cascade');

            $table->string('id_produk',25)->nullable();
            $table->string('id_proyek',25)->nullable();
            $table->string('kbli',7)->nullable();
            $table->string('id_bidang_usaha',10)->nullable();
            $table->string('jenis_produksi',1024)->nullable();
            $table->decimal('kapasitas',20,2)->nullable();
            $table->string('satuan',100)->nullable();
            $table->string('merk_dagang',100)->nullable();
            $table->string('pemegang_haki',100)->nullable();
            $table->string('pemegang_paten',100)->nullable();
            $table->string('pi_nomor',20)->nullable();
            $table->date('pi_tanggal')->nullable();
            $table->string('pi_npwp',16)->nullable();
            $table->string('id_kbli_ta',9)->nullable();
            $table->double('tkdn',3, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_proyek_produk');
    }
}
