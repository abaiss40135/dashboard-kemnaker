<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up()
    {
        Schema::create('sislap_master_data_satpam', function (Blueprint $table) {
            $table->id();
            $table->string('no_reg')->nullable();
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('tinggi_berat_badan')->nullable();
            $table->string('gol_darah')->nullable();
            $table->string('rumus_sidik_jari')->nullable();
            $table->string('handphone')->nullable();
            $table->string('email')->nullable();
            $table->string('dikum_terakhir')->nullable();
            $table->string('npwp')->nullable();
            $table->string('perusahaan')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('alamat_kantor')->nullable();
            $table->string('nomor_kantor')->nullable();
            $table->string('email_perusahaan')->nullable();
            $table->string('dik_terakhir_satpam')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->string('is_ex_tni_polri')->nullable();
            $table->string('pangkat')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->string('kode_satuan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sislap_master_data_satpam');
    }
};
