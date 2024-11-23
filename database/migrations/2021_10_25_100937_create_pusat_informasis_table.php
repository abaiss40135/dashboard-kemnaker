<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePusatInformasisTable extends Migration
{
    public function up()
    {

        DB::statement("
            create materialized view pusat_informasi as
            select key,
                   row_to_json(compiled)                                                             as body,
                   (setweight(to_tsvector('simple', compiled.tags), 'A') || ' ' ||
                    setweight(to_tsvector('indonesian', compiled.title), 'B') || ' ' ||
                    setweight(to_tsvector('indonesian', COALESCE(compiled.description, ''::character varying)), 'D') || ' ' ||
                    setweight(to_tsvector('simple',
                                          coalesce(compiled.author, '') || ' ' || compiled.type || ' ' || compiled.file_extension ||
                                          ' ' ||
                                          compiled.month::text || ' ' || compiled.year::text), 'C')) as search
            from (select 'App\Models\AtensiPimpinan' || '_' || atensi_pimpinans.id as key,
                         atensi_pimpinans.id,
                         judul                                                     as title,
                         strip_tags(isi)                                           as description,
                         pemberi                                                   as author,
                         ''                                                        as thumbnail,
                         ''                                                        as file,
                         ''                                                        as file_extension,
                         'atensi pimpinan'                                         as type,
                         'App\Models\AtensiPimpinan'                               as model,
                         EXTRACT(YEAR FROM created_at)                             as year,
                         to_char(created_at, 'TMmonth')                            as month,
                         EXTRACT(DAY FROM created_at)                              as day,
                         created_at                                                as created_at,
                         jsonb_agg(tagged.tag_slug)                                as tags
                  from atensi_pimpinans
                           left join tagged
                                     on atensi_pimpinans.id = tagged.taggable_id AND
                                        tagged.taggable_type = 'App\Models\AtensiPimpinan'
                  group by atensi_pimpinans.id
                  UNION
                  select 'App\Models\Berita' || beritas.id as key,
                         beritas.id,
                         judul                             as title,
                         strip_tags(isi_berita)            as description,
                         pembuat_berita                    as author,
                         gambar                            as thumbnail,
                         ''                                as file,
                         ''                                as file_extension,
                         'berita'                          as type,
                         'App\Models\Berita'               as model,
                         EXTRACT(YEAR FROM created_at)     as year,
                         to_char(created_at, 'TMmonth')    as month,
                         EXTRACT(DAY FROM created_at)      as day,
                         created_at                        as created_at,
                         jsonb_agg(tagged.tag_slug)        as tags
                  from beritas
                           left join tagged
                                     on beritas.id = tagged.taggable_id AND
                                        tagged.taggable_type = 'App\Models\Berita'
                  group by beritas.id

                  UNION
                  select 'App\Models\Naskah' || '_' || naskahs.id as key,
                         naskahs.id,
                         nama_naskah                              as title,
                         deskripsi_naskah                         as description,
                         ''                                       as author,
                         ''                                       as thumbnail,
                         file_naskah                              as file,
                         substring(file_naskah from '\..*')       as file_extension,
                         'naskah'                                 as type,
                         'App\Models\Naskah'                      as model,
                         EXTRACT(YEAR FROM created_at)            as year,
                         to_char(created_at, 'TMmonth')           as month,
                         EXTRACT(DAY FROM created_at)             as day,
                         created_at                               as created_at,
                         jsonb_agg(tagged.tag_slug)               as tags
                  from naskahs
                           left join tagged
                                     on naskahs.id = tagged.taggable_id AND
                                        tagged.taggable_type = 'App\Models\Naskah'
                  group by naskahs.id

                  UNION
                  select 'App\Models\Paparan' || '_' || paparans.id as key,
                         paparans.id,
                         nama_paparan                               as title,
                         ''                                         as description,
                         ''                                         as author,
                         thumbnail                                  as thumbnail,
                         gambar                                     as file,
                         substring(gambar from '\..*')              as file_extension,
                         'paparan'                                  as type,
                         'App\Models\Paparan'                       as model,
                         EXTRACT(YEAR FROM created_at)              as year,
                         to_char(created_at, 'TMmonth')             as month,
                         EXTRACT(DAY FROM created_at)               as day,
                         created_at                                 as created_at,
                         jsonb_agg(tagged.tag_slug)                 as tags
                  from paparans
                           left join tagged
                                     on paparans.id = tagged.taggable_id AND
                                        tagged.taggable_type = 'App\Models\Paparan'
                  group by paparans.id

                  UNION
                  select 'App\Models\Meme' || '_' || memes.id as key,
                         memes.id,
                         nama_meme                            as title,
                         caption                              as description,
                         ''                                   as author,
                         gambar                               as thumbnail,
                         gambar                               as file,
                         substring(gambar from '\..*')        as file_extension,
                         'meme'                               as type,
                         'App\Models\Meme'                    as model,
                         EXTRACT(YEAR FROM created_at)        as year,
                         to_char(created_at, 'TMmonth')       as month,
                         EXTRACT(DAY FROM created_at)         as day,
                         created_at                           as created_at,
                         jsonb_agg(tagged.tag_slug)           as tags
                  from memes
                           left join tagged
                                     on memes.id = tagged.taggable_id AND
                                        tagged.taggable_type = 'App\Models\Meme'
                  group by memes.id

                  UNION
                  select 'App\Models\Infografis' || '_' || infografis.id as key,
                         infografis.id,
                         judul                                           as title,
                         deskripsi                                       as description,
                         ''                                              as author,
                         gambar                                          as thumbnail,
                         gambar                                          as file,
                         substring(gambar from '\..*')                   as file_extension,
                         'infografis'                                    as type,
                         'App\Models\Infografis'                         as model,
                         EXTRACT(YEAR FROM created_at)                   as year,
                         to_char(created_at, 'TMmonth')                  as month,
                         EXTRACT(DAY FROM created_at)                    as day,
                         created_at                                      as created_at,
                         jsonb_agg(tagged.tag_slug)                      as tags
                  from infografis
                           left join tagged
                                     on infografis.id = tagged.taggable_id AND
                                        tagged.taggable_type = 'App\Models\Infografis'
                  group by infografis.id

                  UNION
                  select 'App\Models\Uu' || '_' || uus.id as key,
                         uus.id,
                         nama_uu                          as title,
                         deskripsi_uu                     as description,
                         ''                               as author,
                         ''                               as thumbnail,
                         file_uu                          as file,
                         substring(file_uu from '\..*')   as file_extension,
                         'uu'                             as type,
                         'App\Models\Uu'                  as model,
                         EXTRACT(YEAR FROM created_at)    as year,
                         to_char(created_at, 'TMmonth')   as month,
                         EXTRACT(DAY FROM created_at)     as day,
                         created_at                       as created_at,
                         jsonb_agg(tagged.tag_slug)       as tags
                  from uus
                           left join tagged
                                     on uus.id = tagged.taggable_id AND
                                        tagged.taggable_type = 'App\Models\Uu'
                  group by uus.id

                  UNION
                  select 'App\Models\UuDalamPolri' || '_' || uu_dalam_polris.id as key,
                         uu_dalam_polris.id,
                         nama_uu                                                as title,
                         deskripsi_uu                                           as description,
                         ''                                                     as author,
                         ''                                                     as thumbnail,
                         file_uu                                                as file,
                         substring(file_uu from '\..*')                         as file_extension,
                         'uu dalam polri'                                       as type,
                         'App\Models\UuDalamPolri'                              as model,
                         EXTRACT(YEAR FROM created_at)                          as year,
                         to_char(created_at, 'TMmonth')                         as month,
                         EXTRACT(DAY FROM created_at)                           as day,
                         created_at                                             as created_at,
                         jsonb_agg(tagged.tag_slug)                             as tags
                  from uu_dalam_polris
                           left join tagged
                                     on uu_dalam_polris.id = tagged.taggable_id AND
                                        tagged.taggable_type = 'App\Models\UuDalamPolri'
                  group by uu_dalam_polris.id

                  UNION
                  select 'App\Models\UuLuarPolri' || '_' || uu_luar_polris.id as key,
                         uu_luar_polris.id,
                         nama_uu                                              as title,
                         deskripsi_uu                                         as description,
                         ''                                                   as author,
                         ''                                                   as thumbnail,
                         file_uu                                              as file,
                         substring(file_uu from '\..*')                       as file_extension,
                         'uu luar polri'                                      as type,
                         'App\Models\UuLuarPolri'                             as model,
                         EXTRACT(YEAR FROM created_at)                        as year,
                         to_char(created_at, 'TMmonth')                       as month,
                         EXTRACT(DAY FROM created_at)                         as day,
                         created_at                                           as created_at,
                         jsonb_agg(tagged.tag_slug)                           as tags
                  from uu_luar_polris
                           left join tagged
                                     on uu_luar_polris.id = tagged.taggable_id AND
                                        tagged.taggable_type = 'App\Models\UuLuarPolri'
                  group by uu_luar_polris.id

                  UNION
                  select 'App\Models\VideoLanding' || '_' || video_landings.id as key,
                         video_landings.id,
                         judul_video                                           as title,
                         ''                                                    as description,
                         ''                                                    as author,
                         file_video                                            as thumbnail,
                         file_video                                            as file,
                         substring(file_video from '\..*')                     as file_extension,
                         'video'                                               as type,
                         'App\Models\VideoLanding'                             as model,
                         EXTRACT(YEAR FROM created_at)                         as year,
                         to_char(created_at, 'TMmonth')                        as month,
                         EXTRACT(DAY FROM created_at)                          as day,
                         created_at                                            as created_at,
                         jsonb_agg(tagged.tag_slug)                            as tags
                  from video_landings
                           left join tagged
                                     on video_landings.id = tagged.taggable_id AND
                                        tagged.taggable_type = 'App\Models\VideoLanding'
                  group by video_landings.id) compiled;");

        DB::statement("alter materialized view pusat_informasi owner to postgres;");
        DB::statement("create unique index pusat_informasi_unique_key on pusat_informasi (key);");
        DB::statement("create index pusat_informasi_search on pusat_informasi using GIN (search);");
        DB::statement('REFRESH MATERIALIZED VIEW CONCURRENTLY pusat_informasi');
    }

    public function down()
    {
        DB::statement('DROP MATERIALIZED VIEW IF EXISTS pusat_informasi');
    }
}
