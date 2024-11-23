<?php

namespace App\Http\Controllers\API\v1\Dashboard;

use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use App\Models\LaporanInformasi;
use App\Models\LaporanPublik;
use App\Models\Problem_solving;
use App\Models\PsNonSengketa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KamtibmasController extends Controller
{
    public function getCountJenisLaporan(Request $request)
    {
        /*
         * 1. Statistik
         *      count DDS, Deteksi Dini, Problem Solving
         *      count bidang DDS
         *
         * */
        return Cache::remember((auth()->user()->personel->kode_satuan ?? auth()->user()->id) . json_encode(request()->all()) . 'api.dashboard.count-jenis.', defaultCacheTime(6 * Constants::CACHE1HOUR), function () use ($request) {
            $countDDS = Dds_warga::query()
                ->has('laporan_informasi')
                ->when($request->has('start_date'), fn($q) => $q->whereDate('tanggal', '>=', $request->get('start_date')))
                ->when($request->has('end_date'), fn($q) => $q->whereDate('tanggal', '<=', $request->get('end_date')))
                ->when($request->has('polda'), fn($q) => $q->where('polda', $this->formatRequestPolda($request->get('polda'))))
                ->count('id');

            $countDD = Deteksi_dini::query()
                ->has('laporan_informasi')
                ->when($request->has('start_date'), fn($q) => $q->whereDate('tanggal', '>=', $request->get('start_date')))
                ->when($request->has('end_date'), fn($q) => $q->whereDate('tanggal', '<=', $request->get('end_date')))
                ->when($request->has('polda'), fn($q) => $q->where('polda', $this->formatRequestPolda($request->get('polda'))))
                ->count('id');

            $psSengketaQuery = Problem_solving::query()
                ->select('id')
                ->when($request->has('start_date'), fn($q) => $q->whereDate('tanggal', '>=', $request->get('start_date')))
                ->when($request->has('end_date'), fn($q) => $q->whereDate('tanggal', '<=', $request->get('end_date')))
                ->when($request->has('polda'), fn($q) => $q->where('polda', $this->formatRequestPolda($request->get('polda'))))
                ->count('id');

            /*$psNonSengketaQuery = PsNonSengketa::query()
                ->select('id')
                ->when($request->has('start_date'), fn ($q) => $q->where('tanggal_kejadian' , '>=', $request->get('start_date')))
                ->when($request->has('end_date'), fn ($q) => $q->where('tanggal_kejadian' , '<=', $request->get('end_date')));

            $countPS = $psSengketaQuery->union($psNonSengketaQuery)->count('id');*/

            return response()->json([
                'from' => $request->has('start_date') ? Carbon::parse($request->get('start_date'))->translatedFormat('l, d F Y') : "",
                'to' => $request->has('end_date') ? Carbon::parse($request->get('end_date'))->translatedFormat('l, d F Y') : "",
                'total' => $countDDS + $countDD + $psSengketaQuery,
                'detail' => [
                    'dds' => $countDDS,
                    'dd' => $countDD,
                    'ps' => $psSengketaQuery
                ]
            ]);
        });
    }

    public function bidang(Request $request)
    {
        return Cache::remember((auth()->user()->personel->kode_satuan ?? auth()->user()->id) . json_encode(request()->all()) . 'api.dashboard.bidang.', defaultCacheTime(6 * Constants::CACHE1HOUR), function () use ($request) {
            $query = LaporanInformasi::query()
                ->whereHasMorph('form', [Dds_warga::class, Deteksi_dini::class], function ($q) use ($request) {
                    $q->when($request->has('start_date'), fn($q) => $q->whereDate('tanggal', '>=', $request->get('start_date')))
                        ->when($request->has('end_date'), fn($q) => $q->whereDate('tanggal', '<=', $request->get('end_date')))
                        ->when($request->has('polda'), fn($q) => $q->where('polda', $this->formatRequestPolda($request->get('polda'))));
                })
                ->select(DB::raw('count(id) as count, bidang'))
                ->groupBy('bidang')
                ->get()->mapWithKeys(function ($item, $key) {
                    return [$item['bidang'] => $item['count']];
                });
            return response()->json($query->toArray());
        });
    }

    public function keyword(Request $request)
    {
        return Cache::remember((auth()->user()->personel->kode_satuan ?? auth()->user()->id) . json_encode(request()->all()) . 'api.dashboard.keyword.', defaultCacheTime(6 * Constants::CACHE1HOUR), function () use ($request) {
            $query = DB::table('keywordables')
                ->whereNotNull(['satuan'])
                ->when($request->has('start_date'), fn($q) => $q->whereDate('keywordables.updated_at', '>=', $request->get('start_date')))
                ->when($request->has('end_date'), fn($q) => $q->whereDate('keywordables.updated_at', '<=', $request->get('end_date')))
                ->when($request->has('polda'), fn($q) => $q->where('satuan', 'ilike', '%' . $this->formatRequestPolda($request->get('polda'))))
                ->join('keywords', function ($join) {
                    $join->on('keywordables.keyword_id', '=', 'keywords.id')
                        ->where('keywords.is_valid', '=', true);
                })
                ->select(DB::raw('keywordables.keyword_id as keyword_id, count(keywordables.keyword_id) as count, keywords.keyword as keyword'))
                ->groupBy(['keyword_id', 'keyword'])
                ->orderByDesc('count')
                ->limit(30)
                ->get();

            return response()->json($query->toArray());
        });
    }

    private function formatRequestPolda($polda)
    {
        if (Str::contains($polda, 'POLDA')) {
            $polda = trim(str_replace('POLDA', '', $polda));
        }
        return $polda;
    }
}
