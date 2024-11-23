<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemegangSahamsTable extends Migration
{
    public function up()
    {
        Schema::create('pemegang_saham', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nib_id');
            $table->foreign('nib_id')
                ->references('id')
                ->on('nomor_induk_berusaha')
                ->onDelete('cascade');

            $table->string('jenis_pemegang_saham', 2)->nullable();
            $table->string('flag_asing', 1)->nullable();
            $table->decimal('total_modal_pemegang', 20, 0)->nullable();
            $table->string('jabatan_pemegang_saham', 50)->nullable();
            $table->string('nama_pemegang_saham', 500)->nullable();
            $table->string('jns_identitas_pemegang_saham', 2)->nullable();
            $table->string('no_identitas_pemegang_saham', 100)->nullable();
            $table->string('valid_identitas_pemegang_saham', 10)->nullable();
            $table->string('pengendali_pemegang_saham', 50)->nullable();
            $table->string('npwp_pemegang_saham', 15)->nullable();
            $table->string('alamat_pemegang_saham', 1024)->nullable();
            $table->string('fax_pemegang_saham', 25)->nullable();
            $table->string('email_pemegang_saham', 100)->nullable();
            $table->string('flag_pajak_pemegang_saham', 2)->nullable();
            $table->string('ket_pajak_pemegang_saham', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pemegang_saham');
    }
}
