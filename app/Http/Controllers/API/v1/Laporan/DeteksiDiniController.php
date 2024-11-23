<?php

namespace App\Http\Controllers\API\v1\Laporan;

use App\Helpers\ApiHelper;
use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Models\Deteksi_dini;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeteksiDiniController extends Controller
{
    public function index()
    {

    }

    public function getLatestLaporan(Request $request)
    {
        $dd = Deteksi_dini::query()
            ->has('personel')
            ->select(array_merge([
                DB::raw("CONCAT(detail_alamat, ' ', rt, '/', rw, ', Desa ', desa, ' Kec. ', kecamatan, ' ', kabupaten, ' ', provinsi) as alamat")
            ], ['*']))
            ->with('laporan_informasi.keywords', 'personel')
            ->when($request->has('start_date'), fn($q) => $q->whereDate('tanggal', '>=', $request->get('start_date')))
            ->when($request->has('end_date'), fn($q) => $q->whereDate('tanggal', '<=', $request->get('end_date')))
            ->when($request->has('polda'), fn($q) => $q->where('polda', $this->formatRequestPolda($request->get('polda'))))
            ->latest()
            ->first();

        return response()->json([
            'personel'  => $dd->personel->nama,
            'foto'      => ApiHelper::getPersonelPhoto($dd->personel->nrp),
            'jabatan'   => $dd->personel->jabatan,
//            'polda'     => $dd->personel->polda,
            'no_hp'     => $dd->personel->handphone,
            'narasumber'=> $dd->nama_narasumber,
            'pekerjaan' => $dd->pekerjaan,
            'alamat'    => $dd->alamat,
//            'waktu'     => $dd->jam_mendapatkan_informasi . ', '. Carbon::createFromFormat('Y-m-d', $dd->tanggal)->translatedFormat(config('app.long_date_format')),
            'bidang'    => strtoupper($dd->laporan_informasi->bidang),
            'uraian'    => $dd->laporan_informasi->uraian,
            'keyword'   => $dd->laporan_informasi->keywords->map(fn ($item, $key) => $item->keyword)->toArray()
        ]);
    }

    public function store(Request $request)
    {
    }

    public function show(Deteksi_dini $deteksi_dini)
    {

    }
    public function update(Request $request, Deteksi_dini $deteksi_dini)
    {
    }

    public function destroy(Deteksi_dini $deteksi_dini)
    {
    }

    private function formatRequestPolda($polda)
    {
        if (Str::contains($polda, 'POLDA')) {
            $polda = trim(str_replace('POLDA', '', $polda));
        }
        return $polda;
    }
}
