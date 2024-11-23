<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sislap_master_data_satpam_belum_dik', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('perusahaan')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('lama_bertugas')->nullable();
            $table->string('dikum_terakhir')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->string('kode_satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sislap_master_data_satpam_belum_dik');
    }
};
