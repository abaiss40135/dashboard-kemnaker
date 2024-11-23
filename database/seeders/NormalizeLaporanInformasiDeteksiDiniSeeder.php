<?php

namespace Database\Seeders;

use App\Models\Deteksi_dini;
use App\Models\Keyword;
use App\Models\LaporanInformasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NormalizeLaporanInformasiDeteksiDiniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            Deteksi_dini::chunk(50, function ($items){
                foreach ($items as $deteksiDini){
                    $laporanInformasi = LaporanInformasi::create([
                        'bidang' => $deteksiDini->bidang_informasi,
                        'uraian' => $deteksiDini->uraian_informasi,
                        'metode' => $deteksiDini->metode_mendapatkan_informasi,
                        'form_id' => $deteksiDini->id,
                        'form_type' => Deteksi_dini::class,
                    ]);

                    $keywords = array();
                    foreach (explode(',', $deteksiDini->keyword) as $keyword) {
                        // increament or create new
                        $queryIfExist = Keyword::where('keyword', $keyword);
                        if ($queryIfExist->exists()) {
                            $keyword = $queryIfExist->first();
                            $queryIfExist->update(['jumlah' => $keyword->laporanInformasis()->count()]);
                            $keywords[] = $keyword;
                        } else {
                            $keywords[] = Keyword::create([
                                'keyword' => $keyword,
                                'jumlah' => 1,
                                'tanggal' => $deteksiDini->tanggal_mendapatkan_informasi
                            ]);
                        }
                    }
                    $laporanInformasi->keywords()->sync(collect($keywords)->pluck('id'));
                }
            });
            DB::commit();
        } catch (\Exception $exception){
            echo $exception->getMessage();
            DB::rollBack();
        }
    }
}
