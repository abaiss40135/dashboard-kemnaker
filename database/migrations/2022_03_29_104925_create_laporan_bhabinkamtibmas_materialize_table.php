<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanBhabinkamtibmasMaterializeTable extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE MATERIALIZED VIEW laporan_bhabinkamtibmas AS
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
                       END                                                                       AS kode_satuan,
                   CASE
                       WHEN laporan_informasi.form_type = 'App\Models\Dds_warga' THEN dw.nama_penerima_kunjungan
                       WHEN laporan_informasi.form_type = 'App\Models\Deteksi_dini' THEN dd.nama_narasumber
                       END                                                                       AS narasumber,
                   laporan_informasi.uraian                                                      AS uraian_informasi,
                   CASE
                       WHEN laporan_informasi.form_type = 'App\Models\Dds_warga' THEN dw.tanggal
                       WHEN laporan_informasi.form_type = 'App\Models\Deteksi_dini' THEN dd.tanggal
                       END                                                                       AS tanggal_laporan,
                   CASE
                       WHEN laporan_informasi.form_type = 'App\Models\Dds_warga' THEN
                                                           dw.detail_alamat_kepala_keluarga || ' ' || dw.desa_kepala_keluarga ||
                                                           ' ' || dw.kecamatan_kepala_keluarga || ' ' ||
                                                           dw.kabupaten_kepala_keluarga || ' ' || dw.provinsi_kepala_keluarga
                       WHEN laporan_informasi.form_type = 'App\Models\Deteksi_dini' THEN
                                                           dd.detail_alamat || ' ' || dd.desa || ' ' || dd.kecamatan || ' ' ||
                                                           dd.kabupaten || ' ' || dd.provinsi
                       END                                                                       AS alamat,
                   array_to_string(t_keyword.tag_array, ',') as tags,
                   laporan_informasi.created_at,
                   laporan_informasi.updated_at
            FROM laporan_informasi
                     LEFT JOIN dds_wargas dw
                               ON laporan_informasi.form_id = dw.id AND laporan_informasi.form_type = 'App\Models\Dds_warga'
                     LEFT JOIN deteksi_dinis dd
                               ON laporan_informasi.form_id = dd.id AND laporan_informasi.form_type = 'App\Models\Deteksi_dini'
                     INNER JOIN users u on dw.user_id = u.id or dd.user_id = u.id
                     LEFT JOIN personel p on u.id = p.user_id,
                 LATERAL ( -- this is an implicit CROSS JOIN
                     SELECT ARRAY(
                                    SELECT keywords.keyword
                                    FROM keywords
                                             INNER JOIN keywordables ON keywords.id = keywordables.keyword_id
                                    WHERE laporan_informasi.id = keywordables.keywordable_id
                                      AND keywordables.keywordable_type = 'App\Models\LaporanInformasi'
                                ) AS tag_array
                     ) t_keyword
            WHERE exists(SELECT *
                         FROM keywords
                                  INNER JOIN keywordables ON keywords.id = keywordables.keyword_id
                         WHERE laporan_informasi.id = keywordables.keywordable_id
                           AND keywordables.keywordable_type = 'App\Models\LaporanInformasi')
              AND (
                    (laporan_informasi.form_type = 'App\Models\Dds_warga' AND
                     exists(SELECT *
                            FROM dds_wargas
                            WHERE laporan_informasi.form_id = dds_wargas.id
                              AND user_id IS NOT NULL)) OR
                    (laporan_informasi.form_type = 'App\Models\Deteksi_dini' AND
                     exists(SELECT *
                            FROM deteksi_dinis
                            WHERE laporan_informasi.form_id = deteksi_dinis.id
                              AND user_id IS NOT NULL)))
              AND (u.nrp IS NOT NULL AND trim(u.nrp) != '')");

        DB::statement("ALTER MATERIALIZED VIEW laporan_bhabinkamtibmas owner to postgres;");
        DB::statement("create unique index laporan_bhabinkamtibmas_unique_key on laporan_bhabinkamtibmas (key);");
    }

    public function down()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS laporan_bhabinkamtibmas');
    }
}
