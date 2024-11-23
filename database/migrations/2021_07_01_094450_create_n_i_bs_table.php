<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNIBsTable extends Migration
{
    public function up()
    {
        Schema::create('nomor_induk_berusaha', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nib', 13)->unique();
            $table->date('tgl_pengajuan_nib')->nullable();
            $table->date('tgl_terbit_nib')->nullable();
            $table->date('tgl_perubahan_nib')->nullable();
            $table->string('oss_id', 25)->nullable();
            $table->string('id_izin', 25)->nullable();
            $table->string('kd_izin', 12)->nullable();
            $table->string('kd_daerah', 10)->nullable();
            $table->string('kewenangan', 2)->nullable();
            $table->string('jenis_pelaku_usaha', 2)->nullable();
            $table->string('no_npp', 20)->nullable();
            $table->string('no_va', 20)->nullable();
            $table->string('no_wlkp', 23)->nullable();
            $table->string('flag_perusahaan', 1)->nullable();
            $table->string('flag_ekspor', 1)->nullable();
            $table->string('flag_impor', 1)->nullable();
            $table->string('jenis_api', 2)->nullable();
            $table->string('gabung_negara', 1)->nullable();
            $table->string('negara_pma_dominan', 2)->nullable();
            $table->decimal('total_pma', 21, 0)->nullable();
            $table->decimal('nilai_pma_dominan', 21, 0)->nullable();
            $table->decimal('nilai_pmdn', 21, 0)->nullable();
            $table->decimal('persen_pma', 9)->nullable();
            $table->decimal('persen_pmdn', 9)->nullable();
            $table->double('kd_kawasan', 5 )->nullable();
            $table->string('jenis_kawasan', 2)->nullable();
            $table->string('versi_pia', 5)->nullable();
            $table->string('jangka_waktu', 10)->nullable();
            $table->string('status_badan_hukum', 2)->nullable();
            $table->string('status_penanaman_modal', 2)->nullable();
            $table->string('npwp_perseroan', 15)->nullable();
            $table->string('nama_perseroan', 255)->nullable();
            $table->string('nama_singkatan', 255)->nullable();
            $table->string('jenis_perseroan', 2)->nullable();
            $table->string('status_perseroan', 1)->nullable();
            $table->string('alamat_perseroan', 255)->nullable();
            $table->string('rt_rw_perseroan', 7)->nullable();
            $table->string('kelurahan_perseroan', 50)->nullable();
            $table->string('perseroan_daerah_id', 10)->nullable();
            $table->string('kode_pos_perseroan', 5)->nullable();
            $table->string('nomor_telpon_perseroan', 20)->nullable();
            $table->string('email_perusahaan', 100)->nullable();
            $table->decimal('dalam_bentuk_uang', 20, 0)->nullable();
            $table->string('dalam_bentuk_lain', 50000)->nullable();
            $table->decimal('total_modal_dasar', 20, 0)->nullable();
            $table->decimal('total_modal_ditempatkan', 20, 0)->nullable();
            $table->string('no_pengesahan', 100)->nullable();
            $table->date('tgl_pengesahan')->nullable();
            $table->string('no_akta_lama', 100)->nullable();
            $table->date('tgl_akta_lama')->nullable();
            $table->string('no_pengesahan_lama', 100)->nullable();
            $table->date('tgl_pengesahan_lama')->nullable();
            $table->string('jenis_id_user_proses',2)->nullable();
            $table->string('no_id_user_proses',25)->nullable();
            $table->string('nama_user_proses',100)->nullable();
            $table->string('email_user_proses',50)->nullable();
            $table->string('hp_user_proses',25)->nullable();
            $table->string('alamat_user_proses',255)->nullable();
            $table->string('jns_kelamin_user_proses',1)->nullable();
            $table->string('tempat_lahir_user_proses',100)->nullable();
            $table->string('tgl_lahir_user_proses',10)->nullable();
            $table->string('daerah_id_user_proses',10)->nullable();
            $table->string('rt_rw_user_proses',10)->nullable();
            $table->string('agama_user_proses',50)->nullable();
            $table->string('status_perkawinan_user_proses',50)->nullable();
            $table->string('pekerjaan_user_proses',50)->nullable();
            $table->string('status_nib',2)->nullable();
            $table->double('tipe_dokumen',1)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nomor_induk_berusaha');
    }
}
