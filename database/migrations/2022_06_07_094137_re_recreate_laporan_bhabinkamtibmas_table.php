<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReRecreateLaporanBhabinkamtibmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS laporan_bhabinkamtibmas');
        DB::statement("
            create materialized view laporan_bhabinkamtibmas as
            SELECT (laporan_informasi.form_type::text || '_'::text) || laporan_informasi.form_id AS key,
                   laporan_informasi.form_id,
                   laporan_informasi.form_type,
                   laporan_informasi.bidang,
                   p.personel_id,
                   p.nama                                                                        AS nama_personel,
                   p.pangkat,
                   u.nrp,
                   p.handphone,
                   split_part(p.satuan1::text, '-'::text, 1)                                     AS polda,
                   split_part(p.satuan2::text, '-'::text, 1)                                     AS polres,
                   split_part(p.satuan3::text, '-'::text, 1)                                     AS polsek,
                   CASE
                       WHEN p.satuan7 IS NOT NULL THEN split_part(p.satuan7::text, '-'::text, 2)
                       WHEN p.satuan6 IS NOT NULL THEN split_part(p.satuan6::text, '-'::text, 2)
                       WHEN p.satuan5 IS NOT NULL THEN split_part(p.satuan5::text, '-'::text, 2)
                       WHEN p.satuan4 IS NOT NULL THEN split_part(p.satuan4::text, '-'::text, 2)
                       WHEN p.satuan3 IS NOT NULL THEN split_part(p.satuan3::text, '-'::text, 2)
                       WHEN p.satuan2 IS NOT NULL THEN split_part(p.satuan2::text, '-'::text, 2)
                       WHEN p.satuan1 IS NOT NULL THEN split_part(p.satuan1::text, '-'::text, 2)
                       ELSE NULL::text
                       END                                                                       AS kode_satuan,
                   CASE
                       WHEN laporan_informasi.form_type::text = 'App\Models\Dds_warga'::text THEN dw.nama_penerima_kunjungan
                       WHEN laporan_informasi.form_type::text = 'App\Models\Deteksi_dini'::text THEN dd.nama_narasumber::text
                       ELSE NULL::text
                       END                                                                       AS narasumber,
                   laporan_informasi.uraian                                                      AS uraian_informasi,
                   CASE
                       WHEN laporan_informasi.form_type::text = 'App\Models\Dds_warga'::text THEN ((
                               (dw.tanggal::text || ' '::text) ||
                               dw.created_at::timestamp without time zone::time without time zone::text))::timestamp without time zone
                       WHEN laporan_informasi.form_type::text = 'App\Models\Deteksi_dini'::text THEN ((
                               ((dd.tanggal::text || ' '::text) || dd.jam_mendapatkan_informasi::text) ||
                               ':00'::text))::timestamp without time zone
                       ELSE NULL::timestamp without time zone
                       END                                                                       AS tanggal_laporan,
                   CASE
                       WHEN laporan_informasi.form_type::text = 'App\Models\Dds_warga'::text THEN
                               (((((((dw.detail_alamat_kepala_keluarga || ', '::text) || dw.desa_kepala_keluarga) || ', '::text) ||
                                   dw.kecamatan_kepala_keluarga) || ', '::text) || dw.kabupaten_kepala_keluarga) || ', '::text) ||
                               dw.provinsi_kepala_keluarga
                       WHEN laporan_informasi.form_type::text = 'App\Models\Deteksi_dini'::text THEN
                               (((((((dd.detail_alamat::text || ', '::text) || dd.desa::text) || ', '::text) ||
                                   dd.kecamatan::text) || ', '::text) || dd.kabupaten::text) || ', '::text) || dd.provinsi::text
                       ELSE NULL::text
                       END                                                                       AS alamat,
                   array_to_string(t_keyword.tag_array, ','::text)                               AS tags,
                   laporan_informasi.created_at,
                   laporan_informasi.updated_at
            FROM laporan_informasi
                     LEFT JOIN dds_wargas dw
                               ON laporan_informasi.form_id = dw.id AND laporan_informasi.form_type::text = 'App\Models\Dds_warga'::text
                     LEFT JOIN deteksi_dinis dd ON laporan_informasi.form_id = dd.id AND
                                                   laporan_informasi.form_type::text = 'App\Models\Deteksi_dini'::text
                     JOIN users u ON dw.user_id = u.id OR dd.user_id = u.id
                     LEFT JOIN personel p ON u.id = p.user_id,
                 LATERAL ( SELECT ARRAY(SELECT keywords.keyword
                                        FROM keywords
                                                 JOIN keywordables ON keywords.id = keywordables.keyword_id
                                        WHERE laporan_informasi.id = keywordables.keywordable_id
                                          AND keywordables.keywordable_type::text =
                                              'App\Models\LaporanInformasi'::text) AS tag_array) t_keyword
            WHERE (EXISTS(SELECT keywords.id,
                                 keywords.keyword,
                                 keywords.jumlah,
                                 keywords.tanggal,
                                 keywords.created_at,
                                 keywords.updated_at,
                                 keywordables.keyword_id,
                                 keywordables.keywordable_type,
                                 keywordables.keywordable_id
                          FROM keywords
                                   JOIN keywordables ON keywords.id = keywordables.keyword_id
                          WHERE laporan_informasi.id = keywordables.keywordable_id
                            AND keywordables.keywordable_type::text = 'App\Models\LaporanInformasi'::text))
              AND (laporan_informasi.form_type::text = 'App\Models\Dds_warga'::text AND (EXISTS(SELECT dds_wargas.id,
                                                                                                       dds_wargas.created_at,
                                                                                                       dds_wargas.updated_at,
                                                                                                       dds_wargas.nama_kepala_keluarga,
                                                                                                       dds_wargas.jenis_kelamin_kepala_keluarga,
                                                                                                       dds_wargas.tempat_lahir_kepala_keluarga,
                                                                                                       dds_wargas.tanggal_lahir_kepala_keluarga,
                                                                                                       dds_wargas.agama_kepala_keluarga,
                                                                                                       dds_wargas.suku_kepala_keluarga,
                                                                                                       dds_wargas.no_tel_kepala_keluarga,
                                                                                                       dds_wargas.pekerjaan_kepala_keluarga,
                                                                                                       dds_wargas.kewarganegaraan_kepala_keluarga,
                                                                                                       dds_wargas.detail_alamat_kepala_keluarga,
                                                                                                       dds_wargas.provinsi_kepala_keluarga,
                                                                                                       dds_wargas.kabupaten_kepala_keluarga,
                                                                                                       dds_wargas.kecamatan_kepala_keluarga,
                                                                                                       dds_wargas.desa_kepala_keluarga,
                                                                                                       dds_wargas.rw_kepala_keluarga,
                                                                                                       dds_wargas.rt_kepala_keluarga,
                                                                                                       dds_wargas.jumlah_anggota_keluarga_serumah,
                                                                                                       dds_wargas.nama_keluarga_bukan_serumah,
                                                                                                       dds_wargas.hubungan,
                                                                                                       dds_wargas.no_tel_keluarga_bukan_serumah,
                                                                                                       dds_wargas.detail_alamat_keluarga_bukan_serumah,
                                                                                                       dds_wargas.provinsi_keluarga_bukan_serumah,
                                                                                                       dds_wargas.kabupaten_keluarga_bukan_serumah,
                                                                                                       dds_wargas.kecamatan_keluarga_bukan_serumah,
                                                                                                       dds_wargas.desa_keluarga_bukan_serumah,
                                                                                                       dds_wargas.rw_keluarga_bukan_serumah,
                                                                                                       dds_wargas.rt_keluarga_bukan_serumah,
                                                                                                       dds_wargas.kunjungan_ke,
                                                                                                       dds_wargas.nama_penerima_kunjungan,
                                                                                                       dds_wargas.foto_kunjungan,
                                                                                                       dds_wargas.keterangan,
                                                                                                       dds_wargas.jenis_pendapat_warga,
                                                                                                       dds_wargas.bidang_pendapat_warga,
                                                                                                       dds_wargas.uraian_pendapat_warga,
                                                                                                       dds_wargas.urgensi,
                                                                                                       dds_wargas.keseringan,
                                                                                                       dds_wargas.penulis,
                                                                                                       dds_wargas.user_id,
                                                                                                       dds_wargas.tanggal,
                                                                                                       dds_wargas.satuan,
                                                                                                       dds_wargas.polda,
                                                                                                       dds_wargas.status_penerima_kunjungan
                                                                                                FROM dds_wargas
                                                                                                WHERE laporan_informasi.form_id = dds_wargas.id
                                                                                                  AND dds_wargas.user_id IS NOT NULL)) OR
                   laporan_informasi.form_type::text = 'App\Models\Deteksi_dini'::text AND (EXISTS(SELECT deteksi_dinis.id,
                                                                                                          deteksi_dinis.created_at,
                                                                                                          deteksi_dinis.updated_at,
                                                                                                          deteksi_dinis.nama_narasumber,
                                                                                                          deteksi_dinis.pekerjaan,
                                                                                                          deteksi_dinis.detail_alamat,
                                                                                                          deteksi_dinis.rt,
                                                                                                          deteksi_dinis.rw,
                                                                                                          deteksi_dinis.desa,
                                                                                                          deteksi_dinis.kecamatan,
                                                                                                          deteksi_dinis.kabupaten,
                                                                                                          deteksi_dinis.provinsi,
                                                                                                          deteksi_dinis.tanggal,
                                                                                                          deteksi_dinis.jam_mendapatkan_informasi,
                                                                                                          deteksi_dinis.lokasi_mendapatkan_informasi,
                                                                                                          deteksi_dinis.urgensi,
                                                                                                          deteksi_dinis.keseringan,
                                                                                                          deteksi_dinis.penulis,
                                                                                                          deteksi_dinis.user_id,
                                                                                                          deteksi_dinis.titik_mendapatkan_informasi,
                                                                                                          deteksi_dinis.polda
                                                                                                   FROM deteksi_dinis
                                                                                                   WHERE laporan_informasi.form_id = deteksi_dinis.id
                                                                                                     AND deteksi_dinis.user_id IS NOT NULL)))
              AND u.nrp IS NOT NULL
              AND btrim(u.nrp::text) <> ''::text;");

        DB::statement("ALTER MATERIALIZED VIEW laporan_bhabinkamtibmas owner to postgres;");
        DB::statement("create unique index laporan_bhabinkamtibmas_unique_key on laporan_bhabinkamtibmas (key);");

        Schema::table('laporan_bhabinkamtibmas', function (Blueprint $table) {
            $table->index('form_id');
            $table->index('form_type');
            $table->index('bidang');
            $table->index('kode_satuan');
            $table->index('tags');
            $table->index(['polda', 'nrp', 'kode_satuan']);
            $table->index(['created_at', 'updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS laporan_bhabinkamtibmas');
    }
}
