<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS akumulasi_laporan_bhabinkamtibmas_view');
       /* DB::statement("
            CREATE materialized view public.akumulasi_laporan_bhabinkamtibmas_view as
            SELECT p.personel_id,
                   p.user_id,
                   u.nrp,
                   CASE
                       WHEN u.last_login_at IS NULL THEN 0
                       ELSE 1
                       END                                                 AS is_logged_in,
                   p.nama,
                   p.pangkat,
                   p.handphone,
                   CASE
                       WHEN p.satuan1 IS NULL THEN 'Tidak terdaftar pada SIPP 2.0'::text
                       ELSE split_part(p.satuan1::text, '-'::text, 1)
                       END                                                 AS polda,
                   CASE
                       WHEN p.satuan2 IS NULL THEN 'Tidak terdaftar pada SIPP 2.0'::text
                       ELSE split_part(p.satuan2::text, '-'::text, 1)
                       END                                                 AS polres,
                   CASE
                       WHEN p.satuan3 IS NULL THEN ''::text
                       ELSE split_part(p.satuan3::text, '-'::text, 1)
                       END                                                 AS polsek,
                   coalesce(alb.jumlah_ps, 0)                              as jumlah_ps,
                   coalesce(alb.jumlah_dds, 0)                             as jumlah_dds,
                   coalesce(alb.jumlah_deteksi_dini, 0)                    as jumlah_deteksi_dini,
                   coalesce(alb.jumlah_ps_eksekutif, 0)                    as jumlah_ps_eksekutif,
                   coalesce(alb.jumlah_ps_non_sengketa, 0)                 as jumlah_ps_non_sengketa,
                   coalesce(alb.jumlah_ps + alb.jumlah_dds + alb.jumlah_deteksi_dini + alb.jumlah_ps_eksekutif +
                            alb.jumlah_ps_non_sengketa, 0)                 AS total_laporan,
                   coalesce(alb.periode, to_char(CURRENT_DATE, 'YYYY-MM')) as periode
            FROM personel p
                     JOIN users u on p.user_id = u.id
                     LEFT JOIN akumulasi_laporan_bhabinkamtibmas alb on p.personel_id = alb.personel_id
            WHERE length(u.nrp::text) = 8
              AND (EXISTS(SELECT role_user.user_id
                          FROM role_user
                          WHERE p.user_id = role_user.user_id
                            AND role_user.role_id = 5));
        ");

        DB::statement('CREATE UNIQUE INDEX akumulasi_bhabinkamtibmas_view_personel_id_periode ON public.akumulasi_laporan_bhabinkamtibmas_view(personel_id, periode);');
        DB::statement('CREATE INDEX akumulasi_bhabinkamtibmas_nama_view_index ON public.akumulasi_laporan_bhabinkamtibmas_view(nama);');
        DB::statement('CREATE INDEX akumulasi_bhabinkamtibmas_polda_viewindex ON public.akumulasi_laporan_bhabinkamtibmas_view(polda);');
        DB::statement('CREATE INDEX akumulasi_bhabinkamtibmas_polres_view_index ON public.akumulasi_laporan_bhabinkamtibmas_view(polres);');
        DB::statement('REFRESH MATERIALIZED VIEW CONCURRENTLY akumulasi_laporan_bhabinkamtibmas_view');*/
    }

    public function down()
    {
        DB::statement("DROP MATERIALIZED VIEW IF EXISTS akumulasi_laporan_bhabinkamtibmas_view");
    }
};
