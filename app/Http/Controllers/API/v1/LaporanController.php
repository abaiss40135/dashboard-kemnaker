<?php

namespace App\Http\Controllers\API\v1;

use App\Helpers\ApiHelper;
use App\Helpers\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use App\Models\Problem_solving;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LaporanController extends Controller
{

    public function get(Request $request)
    {
        /*
         * 1. Statistik
         *      count DDS, Deteksi Dini, Problem Solving
         *      count bidang DDS
         *
         * */
        $DDS = Dds_warga::query()
            ->with('personel:user_id,nrp,nama,jabatan,handphone,satuan1', 'laporan_informasi.keywords')
            ->when($request->has('search') && $request->get('search') !== "", function ($q) use ($request) {
                $q->where(function ($subQuery) use ($request) {
                    $subQuery->where('nama_penerima_kunjungan', 'ilike', '%' . $request->get('search') . '%')
                        ->orWhereHas('laporan_informasi', fn($sq) => $sq->where('uraian', 'ilike', '%' . $request->get('search') . '%'))
                        ->orWhereHas('personel', fn($sq) => $sq->where('nrp', $request->get('search')))
                        ->orWhereHas('personel', fn($sq) => $sq->where('nama', 'ilike', '%' . $request->get('search') . '%'));
                });
            })
            ->when($request->has('bidang') && $request->get('bidang') !== "", function ($q) use ($request) {
                $q->whereHas('laporan_informasi', fn($sq) => $sq->where('bidang', $request->get('bidang')));
            })
            ->when($request->has('keyword_id') && $request->get('keyword_id') !== "", function ($q) use ($request) {
                $q->whereHas('laporan_informasi.keywords', fn($sq) => $sq->where('id', $request->get('keyword_id')));
            })
            ->join('laporan_informasi as li', function ($join) {
                $join->on('dds_wargas.id', '=', 'li.form_id')
                    ->where('li.form_type', '=', Dds_warga::class);
            })
            ->when($request->has('start_date'), fn($q) => $q->whereDate('tanggal', '>=', $request->get('start_date')))
            ->when($request->has('end_date'), fn($q) => $q->whereDate('tanggal', '<=', $request->get('end_date')))
            ->when($request->has('polda'), fn($q) => $q->where('polda', $this->formatRequestPolda($request->get('polda'))))
            ->select(array_merge([
                DB::raw("'" . 'DDS Warga' . "' as type"),
                DB::raw("CONCAT(detail_alamat_kepala_keluarga, ' ', rt_kepala_keluarga, '/', rw_kepala_keluarga, ', Desa ', desa_kepala_keluarga, ' Kec. ', kecamatan_kepala_keluarga, ' ', kabupaten_kepala_keluarga, ' ', provinsi_kepala_keluarga) as alamat")
            ], ['dds_wargas.id', 'user_id', 'nama_penerima_kunjungan as nama_narasumber', 'pekerjaan_kepala_keluarga as pekerjaan', 'tanggal', 'li.uraian as uraian', 'dds_wargas.created_at as created_at']));

        $DD = Deteksi_dini::query()
            ->with('personel:user_id,nrp,nama,jabatan,handphone,satuan1', 'laporan_informasi.keywords:id,keyword')
            ->when($request->has('search') && $request->get('search') !== "", function ($q) use ($request) {
                $q->where(function ($subQuery) use ($request) {
                    $subQuery->where('nama_narasumber', 'ilike', '%' . $request->get('search') . '%')
                        ->orWhereHas('laporan_informasi', fn($sq) => $sq->where('uraian', 'ilike', '%' . $request->get('search') . '%'))
                        ->orWhereHas('personel', fn($sq) => $sq->where('nrp', $request->get('search')))
                        ->orWhereHas('personel', fn($sq) => $sq->where('nama', 'ilike', '%' . $request->get('search') . '%'));
                });
            })
            ->when($request->has('bidang') && $request->get('bidang') !== "", function ($q) use ($request) {
                $q->whereHas('laporan_informasi', fn($sq) => $sq->where('bidang', $request->get('bidang')));
            })
            ->when($request->has('keyword_id'), function ($q) use ($request) {
                $q->whereHas('laporan_informasi.keywords', fn($sq) => $sq->where('id', $request->get('keyword_id')));
            })
            ->join('laporan_informasi as li', function ($join) {
                $join->on('deteksi_dinis.id', '=', 'li.form_id')
                    ->where('li.form_type', '=', Deteksi_dini::class);
            })
            ->when($request->has('start_date'), fn($q) => $q->whereDate('tanggal', '>=', $request->get('start_date')))
            ->when($request->has('end_date'), fn($q) => $q->whereDate('tanggal', '<=', $request->get('end_date')))
            ->when($request->has('polda'), fn($q) => $q->where('polda', $this->formatRequestPolda($request->get('polda'))))
            ->select(array_merge([
                DB::raw("'" . 'Deteksi Dini' . "' as type"),
                DB::raw("CONCAT(detail_alamat, ' ', rt, '/', rw, ', Desa ', desa, ' Kec. ', kecamatan, ' ', kabupaten, ' ', provinsi) as alamat")
            ], ['deteksi_dinis.id', 'user_id', 'nama_narasumber', 'pekerjaan', 'tanggal', 'li.uraian as uraian', 'deteksi_dinis.created_at as created_at']));

        $psSengketaQuery = Problem_solving::query()
            ->with('personel:user_id,nrp,nama,jabatan,handphone,satuan1', 'keywords')
            ->when($request->has('search') && $request->get('search') !== "", function ($q) use ($request) {
                $q->where('nama_narasumber', 'ilike', '%' . $request->get('search') . '%')
                    ->orWhere('uraian_kejadian', 'ilike', '%' . $request->get('search') . '%')
                    ->orWhereHas('personel', fn($sq) => $sq->where('nrp', $request->get('search')))
                    ->orWhereHas('personel', fn($sq) => $sq->where('nama', 'ilike', '%' . $request->get('search') . '%'));
            })
            ->when($request->has('keyword_id') && $request->get('keyword_id') !== "", function ($q) use ($request) {
                $q->whereHas('keywords', fn($sq) => $sq->where('id', $request->get('keyword_id')));
            })
            ->when($request->has('start_date'), fn($q) => $q->whereDate('tanggal', '>=', $request->get('start_date')))
            ->when($request->has('end_date'), fn($q) => $q->whereDate('tanggal', '<=', $request->get('end_date')))
            ->when($request->has('polda'), fn($q) => $q->where('polda', $this->formatRequestPolda($request->get('polda'))))
            ->select(array_merge([DB::raw("'" . 'Problem Solving' . "' as type")], ['alamat_narasumber as alamat', 'id', 'user_id', 'nama_narasumber', 'pekerjaan_narasumber as pekerjaan', 'tanggal', 'uraian_kejadian as uraian', 'created_at']));

        $unionQuery = $DDS
            ->union($DD)
            ->union($psSengketaQuery)
            ->orderByDesc('tanggal')
            ->limit(32);

        $collection = $unionQuery->get();
        if ($request->has('jenis') && $request->get('jenis') !== "") {
            $collection = $collection->where('type', '=',$request->get('jenis') === 'dds' ? 'DDS Warga' : ($request->get('jenis') === 'deteksi_dini' ? 'Deteksi Dini' : 'Problem Solving'));
        }

        $transformedDatas = $collection->map(function ($data) {
            try {
                $keywords = $data->type === "Problem Solving" ? $data->keywords : $data->laporan_informasi->keywords;
                return [
                    'jenis' => $data->type,
                    'form_id' => $data->id,
                    'personel' => $data->personel->nama,
//                    'foto' => ApiHelper::getPersonelPhoto($data->personel->nrp),
                    'jabatan' => $data->personel->jabatan,
                    'polda' => $data->personel->polda,
                    'no_hp' => $data->personel->handphone,
                    'narasumber' => $data->nama_narasumber,
                    'pekerjaan' => $data->pekerjaan,
                    'alamat' => $data->alamat,
                    'waktu' => Carbon::createFromFormat('Y-m-d', $data->tanggal)->translatedFormat(config('app.long_date_format')),
                    'bidang' => strtoupper($data->laporan_informasi?->bidang),
                    'uraian' => $data->uraian,
                    'keyword' => $keywords->map(fn($item, $key) => $item->keyword)->toArray()
                ];
            } catch (\Exception $exception) {
                \Log::warning('LaporanController@get', $data->toArray());
                return [];
            }
        })->filter();

        return response()->json(CollectionHelper::paginate($transformedDatas, 4));
    }

    private function formatRequestPolda($polda)
    {
        if (Str::contains($polda, 'POLDA')) {
            $polda = trim(str_replace('POLDA', '', $polda));
        }
        return $polda;
    }
}
