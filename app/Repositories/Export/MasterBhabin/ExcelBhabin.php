<?php

namespace App\Repositories\Export\MasterBhabin;

use App\Actions\RefreshAkumulasiLaporanBhabinkamtibmasViewTableAction;
use App\Helpers\ApiHelper;
use App\Helpers\Constants;
use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use App\Models\LokasiPenugasan;
use App\Models\Problem_solving;
use App\Models\PsNonSengketa;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Throwable;

class ExcelBhabin implements FromView, ShouldQueue
{

    use Exportable;

    private $code, $cityCodeMetroJaya, $districtCodeBanten, $bhabins, $dds_warga;
    /**
     * @var array
     */
    private $districtCodeMetro;

    public function __construct($code, array $cityCodeMetroJaya, array $districtCodeBanten, array $districtCodeMetro)
    {
        $this->code = $code;
        $this->cityCodeMetroJaya = $cityCodeMetroJaya;
        $this->districtCodeMetro = $districtCodeMetro;
        $this->districtCodeBanten = $districtCodeBanten;
    }

    public function collection()
    {
        $query = LokasiPenugasan::query()
            ->with(['akumulasiLaporanUser' => function($query){
                $query->where('periode', request('periode', now()->format('Y-m')));
            }])
            ->whereHas('user', function ($query) {
                $query->hasNrp()->isBhabinkamtibmas();
            })
            ->when(request()->has('periode'), function ($query) {
                $query->whereHas('akumulasiLaporanUser', function ($query){
                    $query->where('periode', request('periode', now()->format('Y-m')));
                });
            })
            ->where('lokasi_penugasans.province_code', $this->code)
            ->leftJoin('users', 'users.id', '=', 'lokasi_penugasans.user_id')
            ->leftJoin('provinces', 'provinces.code', '=', 'lokasi_penugasans.province_code')
            ->leftJoin('cities', 'cities.code', '=', 'lokasi_penugasans.city_code')
            ->leftJoin('districts', 'districts.code', '=', 'lokasi_penugasans.district_code')
            ->leftJoin('villages', 'villages.code', '=', 'lokasi_penugasans.village_code')
            ->select('nrp', 'provinces.name as provinsi', 'cities.name as kota', 'districts.name as kecamatan', 'villages.name as desa', 'lokasi_penugasans.user_id as user_id');

        $tambahan = collect();
        if ($this->code == Constants::idMetroJaya) {
            $tambahan = LokasiPenugasan::query()
                ->whereHas('user', function ($query) {
                    $query->hasNrp()->isBhabinkamtibmas();
                })
                ->with(['akumulasiLaporanUser' => function($query){
                    $query->where('periode', request('periode', now()->format('Y-m')));
                }])
                ->when(request()->has('periode'), function ($query) {
                    $query->whereHas('akumulasiLaporanUser', function ($query){
                        $query->where('periode', request('periode', now()->format('Y-m')));
                    });
                })
                ->when(request()->has('periode'), function ($query) {
                    $query->whereHas('akumulasiLaporanUser', function ($query){
                        $query->where('periode', request('periode', now()->format('Y-m')));
                    });
                })
                ->whereIn('lokasi_penugasans.city_code', $this->cityCodeMetroJaya)
                ->whereIn('lokasi_penugasans.district_code', $this->districtCodeMetro)
                ->leftJoin('users', 'users.id', '=', 'lokasi_penugasans.user_id')
                ->leftJoin('provinces', 'provinces.code', '=', 'lokasi_penugasans.province_code')
                ->leftJoin('cities', 'cities.code', '=', 'lokasi_penugasans.city_code')
                ->leftJoin('districts', 'districts.code', '=', 'lokasi_penugasans.district_code')
                ->leftJoin('villages', 'villages.code', '=', 'lokasi_penugasans.village_code')
                ->select('nrp', 'provinces.name as provinsi', 'cities.name as kota', 'districts.name as kecamatan', 'villages.name as desa', 'lokasi_penugasans.user_id as user_id')
                ->orderBy('lokasi_penugasans.user_id')
                ->distinct('lokasi_penugasans.user_id')
                ->get();
        } else if ($this->code == Constants::idBanten) {
            $query
//                ->whereNotIn('lokasi_penugasans.city_code', $this->cityCodeMetroJaya)
                ->whereNotIn('lokasi_penugasans.district_code', array_merge($this->districtCodeMetro, $this->districtCodeBanten));

            $tambahan = LokasiPenugasan::query()
                ->with(['akumulasiLaporanUser' => function($query){
                    $query->where('periode', request('periode', now()->format('Y-m')));
                }])
                ->whereHas('user', function ($query) {
                    $query->hasNrp()->isBhabinkamtibmas();
                })
                ->when(request()->has('periode'), function ($query) {
                    $query->whereHas('akumulasiLaporanUser', function ($query){
                        $query->where('periode', request('periode', now()->format('Y-m')));
                    });
                })
                ->where(function ($query) {
                    $query->whereHas('personel', function ($query) {
                        $query->where('satuan3', 'SIMILAR TO', '%(2131810|2131811)');
                    })
                        ->orWhereIn('lokasi_penugasans.district_code', $this->districtCodeBanten);
                })
                ->leftJoin('users', 'users.id', '=', 'lokasi_penugasans.user_id')
                ->leftJoin('provinces', 'provinces.code', '=', 'lokasi_penugasans.province_code')
                ->leftJoin('cities', 'cities.code', '=', 'lokasi_penugasans.city_code')
                ->leftJoin('districts', 'districts.code', '=', 'lokasi_penugasans.district_code')
                ->leftJoin('villages', 'villages.code', '=', 'lokasi_penugasans.village_code')
                ->select('nrp', 'provinces.name as provinsi', 'cities.name as kota', 'districts.name as kecamatan', 'villages.name as desa', 'lokasi_penugasans.user_id as user_id')
                ->orderBy('lokasi_penugasans.user_id')
                ->distinct('lokasi_penugasans.user_id')
                ->get();
        }
        $temp = $query
                ->orderBy('lokasi_penugasans.user_id')
                ->distinct('lokasi_penugasans.user_id')->get();
        return $temp->concat($tambahan);
    }


    public function view(): View
    {
        /*$refreshAkumulasiLaporanView = new RefreshAkumulasiLaporanBhabinkamtibmasViewTableAction();
        $refreshAkumulasiLaporanView->execute();*/
        return view('excel.bhabin', ['bhabins' => $this->collection()]);
    }

    public function failed(Throwable $exception): void
    {
        Log::error('Excel Log: ' . $exception->getMessage());
    }
}
