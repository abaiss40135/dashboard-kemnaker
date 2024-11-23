<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLaporanSatpamMaterializeViewTable extends Migration
{
    public function up()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS laporan_satpam');
        DB::statement("
            create materialized view laporan_satpam as
            SELECT 'App\Models\LaporanInformasiSatpam' || laporan_informasi_satpams.id           as key,
                   laporan_informasi_satpams.id                                                  as form_id,
                   'App\Models\LaporanInformasiSatpam'                                           as form_type,
                   bidang_informasi                                                              as bidang,
                   satpam_id,
                   s.nama,
                   s.no_kta,
                   s.no_hp                                                                       as handphone,
                   s.provinsi,
                   s.kabupaten,
                   s.kecamatan,
                   s.desa,
                   nama_narasumber                                                               as narasumber,
                   uraian_informasi,
                   tanggal_mendapatkan_informasi                                                 as tanggal_laporan,
                   laporan_informasi_satpams.provinsi || ', ' || laporan_informasi_satpams.kabupaten || ', ' ||
                   laporan_informasi_satpams.kecamatan || ', ' || laporan_informasi_satpams.desa as alamat,
                   keyword                                                                       as tags,
                   laporan_informasi_satpams.created_at,
                   laporan_informasi_satpams.updated_at
            FROM laporan_informasi_satpams
                     INNER JOIN satpams s on s.id = laporan_informasi_satpams.satpam_id
            UNION
            SELECT 'App\Models\LaporanKejadianSatpam' || laporan_kejadian_satpams.id           as key,
                   laporan_kejadian_satpams.id                                                 as form_id,
                   'App\Models\LaporanKejadianSatpam'                                          as form_type,
                   'laporan_kejadian'                                                          as bidang,
                   satpam_id,
                   s.nama,
                   s.no_kta,
                   s.no_hp                                                                     as handphone,
                   s.provinsi,
                   s.kabupaten,
                   s.kecamatan,
                   s.desa,
                   nama_korban                                                                 as narasumber,
                   uraian_kejadian                                                             as uraian_informasi,
                   tanggal_dilaporkan::date                                                    as tanggal_laporan,
                   laporan_kejadian_satpams.provinsi || ', ' || laporan_kejadian_satpams.kabupaten || ', ' ||
                   laporan_kejadian_satpams.kecamatan || ', ' || laporan_kejadian_satpams.desa as alamat,
                   lower(tindak_pidana)                                                        as tags,
                   laporan_kejadian_satpams.created_at,
                   laporan_kejadian_satpams.updated_at
            from laporan_kejadian_satpams
                     INNER JOIN satpams s on s.id = laporan_kejadian_satpams.satpam_id;");
        DB::statement("ALTER MATERIALIZED VIEW laporan_satpam owner to postgres;");
        DB::statement("create unique index laporan_satpam_unique_key on laporan_satpam (key);");

        Schema::table('laporan_satpam', function (Blueprint $table) {
            $table->index('form_id');
            $table->index('form_type');
            $table->index('bidang');
            $table->index('tags');
            $table->index(['provinsi']);
            $table->index(['created_at', 'updated_at']);
        });

    }

    public function down()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS laporan_satpam');
    }
}
