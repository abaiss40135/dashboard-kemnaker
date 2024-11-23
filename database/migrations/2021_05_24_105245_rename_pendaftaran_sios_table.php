<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePendaftaranSiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_sios' , function(Blueprint $table){
            $table->renameColumn('daftar_riwayat_hidup_pimpinan' , 'cv');
            $table->renameColumn('surat_izin_operasional' , 'bukti_setoran_pnpb');
            $table->string('sertifikat_iso')->nullable();
            $table->string('sertifikat_apjatin')->nullable();
            $table->string('surat_keputusan_bank')->nullable();
            $table->string('sertifikat_tenaga_ahli')->nullable()->change();
        });

        if(Schema::hasColumn('pendaftaran_sios' , 'surat_rekom_polda')){
            Schema::table('pendaftaran_sios' , function(Blueprint $table){
                $table->dropColumn('surat_rekom_polda');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('pendaftaran_sios' , function(Blueprint $table){
            $table->renameColumn('cv' , 'daftar_riwayat_hidup_pimpinan');
            $table->renameColumn('bukti_setoran_pnpb' , 'surat_izin_operasional');
            $table->dropColumn(['sertifikat_iso' , 'sertifikat_apjatin' , 'surat_keputusan_bank']);
        });
    }
}
