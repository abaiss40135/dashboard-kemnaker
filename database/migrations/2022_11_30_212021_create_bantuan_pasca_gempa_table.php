<?php

use App\Models\Personel;
use App\Models\Sislap\Nonlapbul\PascaGempaCianjur\JenisGiatPascaGempa;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sislap_bantuan_pasca_gempa', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Personel::class, 'personel_id');
            $table->string('lokasi_kegiatan');
            $table->char('district_code', 7);
            $table->foreign('district_code')->references('code')->on('districts')->cascadeOnUpdate();
            $table->date('tanggal');
            $table->foreignIdFor(JenisGiatPascaGempa::class, 'jenis_kegiatan_id');
            $table->string('uraian_kegiatan');

            $table->string('kode_satuan'); 
            $table->foreignIdFor(User::class, 'user_id');
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
        Schema::dropIfExists('sislap_bantuan_pasca_gempa');
    }
};
