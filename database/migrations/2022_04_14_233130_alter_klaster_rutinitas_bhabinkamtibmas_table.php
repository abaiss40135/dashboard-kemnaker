<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKlasterRutinitasBhabinkamtibmasTable extends Migration
{
    public function up()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS klaster_rutinitas_bhabinkamtibmas');
        DB::statement("
            CREATE MATERIALIZED VIEW public.klaster_rutinitas_bhabinkamtibmas
                TABLESPACE pg_default
            AS
            SELECT join_user.user_id,
                   p.personel_id,
                   p.nama,
                   p.pangkat,
                   join_user.nrp,
                   split_part(p.satuan1::text, '-'::text, 1) AS polda,
                   split_part(p.satuan2::text, '-'::text, 1) AS polres,
                   split_part(p.satuan3::text, '-'::text, 1) AS polsek,
                   CASE
                       WHEN p.satuan7 IS NOT NULL THEN split_part(p.satuan7::text, '-'::text, 2)
                       WHEN p.satuan6 IS NOT NULL THEN split_part(p.satuan6::text, '-'::text, 2)
                       WHEN p.satuan5 IS NOT NULL THEN split_part(p.satuan5::text, '-'::text, 2)
                       WHEN p.satuan4 IS NOT NULL THEN split_part(p.satuan4::text, '-'::text, 2)
                       WHEN p.satuan3 IS NOT NULL THEN split_part(p.satuan3::text, '-'::text, 2)
                       WHEN p.satuan2 IS NOT NULL THEN split_part(p.satuan2::text, '-'::text, 2)
                       WHEN p.satuan1 IS NOT NULL THEN split_part(p.satuan1::text, '-'::text, 2)
END                                                                       AS kode_satuan,
                   join_user.is_logged_in,
                   join_user.total_laporan,
                   CASE
                       WHEN join_user.total_laporan > 3 THEN 'aktif'::text
                       WHEN join_user.total_laporan > 0 THEN 'cukup'::text
                       ELSE 'kurang'::text
                       END                                   AS klaster_rutinitas
            FROM (SELECT first_user.user_id,
                         first_user.nrp,
                         first_user.is_logged_in,
                         first_user.jumlah_dds + first_user.jumlah_deteksi_dini + first_user.jumlah_ps +
                         first_user.jumlah_ps_non_sengketa + first_user.jumlah_ps_eksekutif AS total_laporan
                  FROM (SELECT users.id               AS user_id,
                               users.nrp,
                               CASE
                                   WHEN users.last_login_at IS NULL THEN 0
                                   ELSE 1
                                   END                AS is_logged_in,
                               COUNT(DISTINCT ps.id)  AS jumlah_ps,
                               COUNT(DISTINCT dw.id)  AS jumlah_dds,
                               COUNT(DISTINCT dd.id)  AS jumlah_deteksi_dini,
                               COUNT(DISTINCT pe.id)  AS jumlah_ps_eksekutif,
                               COUNT(DISTINCT pns.id) AS jumlah_ps_non_sengketa
                        FROM users
                                 LEFT JOIN problem_solvings ps
                                           ON users.id = ps.user_id AND ps.updated_at > (CURRENT_DATE - '7 days'::interval)
                                 LEFT JOIN dds_wargas dw
                                           ON users.id = dw.user_id AND dw.updated_at > (CURRENT_DATE - '7 days'::interval)
                                 LEFT JOIN deteksi_dinis dd
                                           ON users.id = dd.user_id AND dd.updated_at > (CURRENT_DATE - '7 days'::interval)
                                 LEFT JOIN ps_eksekutifs pe
                                           ON users.id = pe.user_id AND pe.updated_at > (CURRENT_DATE - '7 days'::interval)
                                 LEFT JOIN ps_non_sengketas pns
                                           ON users.id = pns.user_id AND pns.updated_at > (CURRENT_DATE - '7 days'::interval)
                        GROUP BY users.id) first_user) join_user
                     LEFT JOIN personel p ON join_user.user_id = p.user_id
            WHERE length(join_user.nrp::text) = 8
              AND (EXISTS(SELECT roles.id
                          FROM roles
                                   JOIN role_user ON roles.id = role_user.role_id
                          WHERE join_user.user_id = role_user.user_id
                            AND roles.name::text ~~ '%bhabinkamtibmas'::text))
            ORDER BY p.personel_id
            WITH DATA;
        ");

        DB::statement('CREATE UNIQUE INDEX bhabinkamtibmas_user_id ON public.klaster_rutinitas_bhabinkamtibmas(user_id);');
        DB::statement('CREATE INDEX bhabinkamtibmas_nama_index ON public. klaster_rutinitas_bhabinkamtibmas(nama);');
        DB::statement('CREATE INDEX bhabinkamtibmas_klaster_index ON public.klaster_rutinitas_bhabinkamtibmas(klaster_rutinitas);');
        DB::statement('CREATE INDEX bhabinkamtibmas_polda_index ON public.klaster_rutinitas_bhabinkamtibmas(polda);');
        DB::statement('CREATE INDEX bhabinkamtibmas_kode_satuan_index ON public.klaster_rutinitas_bhabinkamtibmas(kode_satuan);');
        DB::statement('REFRESH MATERIALIZED VIEW CONCURRENTLY klaster_rutinitas_bhabinkamtibmas');
    }

    public function down()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS klaster_rutinitas_bhabinkamtibmas');
    }
}
