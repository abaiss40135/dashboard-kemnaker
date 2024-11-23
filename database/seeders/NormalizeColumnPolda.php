<?php

namespace Database\Seeders;

use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use App\Models\Problem_solving;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class NormalizeColumnPolda extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seeder ini buat ngisi polda berdasarkan provinsi laporan
        DB::beginTransaction();
        try {
            Dds_warga::select('id', 'provinsi_kepala_keluarga')->get()->each(function ($item){
                $item->update(['polda' => Lang::get('abbreviation')[$item->provinsi_kepala_keluarga]]);
            });
            Deteksi_dini::select('id', 'provinsi')->get()->each(function ($item){
                $item->update(['polda' => Lang::get('abbreviation')[Str::upper($item->provinsi)]]);
            });
            Problem_solving::select('id', 'provinsi_pihak_1')->get()->each(function ($item){
                $item->update(['polda' => Lang::get('abbreviation')[Str::upper($item->provinsi_pihak_1)]]);
            });
            DB::commit();
        } catch (\Exception $exception){
            DB::rollBack();
        }

    }
}
