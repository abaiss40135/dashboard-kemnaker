<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAkumulasiLaporanBhabinkamtibmasMaterializeView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS akumulasi_laporan_bhabinkamtibmas');
        DB::statement("
            CREATE materialized view public.akumulasi_laporan_bhabinkamtibmas as
            SELECT p.personel_id,
                   p.nama,
                   p.pangkat,
                   p.handphone,
                   CASE
                       WHEN p.satuan1 IS NULL THEN 'Tidak terdaftar pada SIPP 2.0'::text
                       ELSE split_part(p.satuan1::text, '-'::text, 1)
                       END AS polda,
                   CASE
                       WHEN p.satuan2 IS NULL THEN 'Tidak terdaftar pada SIPP 2.0'::text
                       ELSE split_part(p.satuan2::text, '-'::text, 1)
                       END AS polres,
                   CASE
                       WHEN p.satuan3 IS NULL THEN 'Tidak terdaftar pada SIPP 2.0'::text
                       ELSE split_part(p.satuan3::text, '-'::text, 1)
                       END AS polsek,
                   join_user.*
            FROM (SELECT first_user.*,
                         first_user.jumlah_dds + first_user.jumlah_deteksi_dini + first_user.jumlah_ps +
                         first_user.jumlah_ps_non_sengketa + first_user.jumlah_ps_eksekutif AS total_laporan
                  FROM (SELECT users.id               AS user_id,
                               users.nrp,
                               CASE
                                   WHEN users.last_login_at IS NULL THEN 0
                                   ELSE 1
                                   END                AS is_logged_in,
                               count(DISTINCT ps.id) AS jumlah_ps,
                               count(DISTINCT dw.id) AS jumlah_dds,
                               count(DISTINCT dd.id) AS jumlah_deteksi_dini,
                               count(DISTINCT pe.id) AS jumlah_ps_eksekutif,
                               count(DISTINCT pns.id) AS jumlah_ps_non_sengketa
                        FROM users
                                 LEFT JOIN problem_solvings ps ON users.id = ps.user_id AND extract(month from ps.created_at) = date_part('year', current_timestamp) and extract(year from ps.created_at) = date_part('month', current_timestamp)
                                 LEFT JOIN dds_wargas dw ON users.id = dw.user_id AND extract(month from dw.created_at) = date_part('year', current_timestamp) and extract(year from dw.created_at) = date_part('month', current_timestamp)
                                 LEFT JOIN deteksi_dinis dd ON users.id = dd.user_id AND extract(month from dd.created_at) = date_part('year', current_timestamp) and extract(year from dd.created_at) = date_part('month', current_timestamp)
                                 LEFT JOIN ps_eksekutifs pe ON users.id = pe.user_id AND extract(month from pe.created_at) = date_part('year', current_timestamp) and extract(year from pe.created_at) = date_part('month', current_timestamp)
                                 LEFT JOIN ps_non_sengketas pns ON users.id = pns.user_id AND extract(month from pns.created_at) = date_part('year', current_timestamp) and extract(year from pns.created_at) = date_part('month', current_timestamp)
                        GROUP BY users.id) first_user) join_user
                     LEFT JOIN personel p ON join_user.user_id = p.user_id
            WHERE length(join_user.nrp::text) = 8
              AND (EXISTS(SELECT roles.id
                          FROM roles
                                   JOIN role_user ON roles.id = role_user.role_id
                          WHERE join_user.user_id = role_user.user_id
                            AND roles.name::text ~~ '%bhabinkamtibmas'::text))
            ORDER BY p.personel_id;
        ");

        DB::statement('CREATE UNIQUE INDEX akumulasi_bhabinkamtibmas_user_id ON public.akumulasi_laporan_bhabinkamtibmas(user_id);');
        DB::statement('CREATE INDEX akumulasi_bhabinkamtibmas_nama_index ON public.akumulasi_laporan_bhabinkamtibmas(nama);');
        DB::statement('CREATE INDEX akumulasi_bhabinkamtibmas_polda_index ON public.akumulasi_laporan_bhabinkamtibmas(polda);');
        DB::statement('CREATE INDEX akumulasi_bhabinkamtibmas_polres_index ON public.akumulasi_laporan_bhabinkamtibmas(polres);');
        DB::statement('REFRESH MATERIALIZED VIEW CONCURRENTLY akumulasi_laporan_bhabinkamtibmas');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS akumulasi_laporan_bhabinkamtibmas");
    }
}
