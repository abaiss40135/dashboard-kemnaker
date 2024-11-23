<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_polisi_rw', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Personel::class, 'personel_id');
            $table->foreignIdFor(\App\Models\Desa::class, 'village_code');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('nama');
            $table->string('jenis');
            $table->string('nik', 16);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['LAKI-LAKI', 'PEREMPUAN']);
            $table->string('hp', 16);
            $table->foreignIdFor(\App\Models\PolisiRW\Pekerjaan::class)->nullable();
            $table->string('kejahatan');
            $table->text('motif');
            $table->foreignIdFor(\App\Models\PolisiRW\AlatKejahatan::class)->nullable();
            $table->enum('sarana', ['MOTOR', 'MOBIL'])->nullable();
            $table->smallInteger('jumlah_roda')->nullable();
            $table->boolean('surat_sah')->nullable();
            $table->boolean('miras')->default(false);
            $table->boolean('narkoba')->default(false);
            $table->foreignIdFor(\App\Models\PolisiRW\KategoriKegiatan::class)->nullable();
            $table->foreignIdFor(\App\Models\PolisiRW\KategoriKerawanan::class)->nullable();
            $table->text('keterangan')->nullable();
            $table->jsonb('foto')->nullable();
            $table->foreignIdFor(\App\Models\Sipp\Satuan::class, 'kode_satuan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_polisi_rw');
    }
};
