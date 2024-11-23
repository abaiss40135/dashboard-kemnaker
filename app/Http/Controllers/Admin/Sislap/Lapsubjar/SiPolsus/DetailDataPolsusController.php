<?php

namespace App\Http\Controllers\Admin\Sislap\Lapsubjar\SiPolsus;

use App\Http\Controllers\Controller;
use App\Http\Traits\CustomPaginationTrait;
use App\Models\Instansi;
use App\Models\Polsus;
use Illuminate\Http\Request;

class DetailDataPolsusController extends Controller
{
    use CustomPaginationTrait;

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->post();
        $query = Polsus::query()->with('instansi')
        ->filterPolsusAktif()
        ->filterRolePolisiKhusus()
        ->filterByPolsusProvinceAndKabupaten()
        ->filterByAttributeUser()
        ->where('provinsi', 'ilike', '%'. $data['provinsi'] .'%')
        ->where('kabupaten', 'ilike', '%'. $data['kotakab'] .'%')
        ->when($data['search'], function ($query) use ($data) {
            $arr_search = explode(' ', $data['search']);
            if($kelurahan = array_search('kelurahan', $arr_search)) {
                unset($arr_search[$kelurahan]);
            }
            if($kecamatan = array_search('kecamatan', $arr_search)) {
                unset($arr_search[$kecamatan]);
            }
            if($provinsi = array_search('provinsi', $arr_search)) {
                unset($arr_search[$provinsi]);
            }

            $search_query = implode(' ', $arr_search);
            $query->where(function($q) use ($search_query) {
                $q->where('nama', 'ilike', '%'. $search_query .'%')
                    ->orWhere('pangkat', 'ilike', '%'. $search_query .'%')
                    ->orWhere('golongan', 'ilike', '%'. $search_query .'%')
                    ->orWhere('jabatan', 'ilike', '%'. $search_query .'%')
                    ->orWhere('no_nip', 'ilike', '%'. $search_query .'%')
                    ->orWhere('provinsi', 'ilike', '%'. $search_query .'%')
                    ->orWhere('kabupaten', 'ilike', '%'. $search_query .'%')
                    ->orWhere('kecamatan', 'ilike', '%'. $search_query .'%')
                    ->orWhere('desa', 'ilike', '%'. $search_query .'%')
                    ->orWhere('detail_alamat', 'ilike', '%'. $search_query .'%')
                    ->orWhere('kategori', 'ilike', '%'. $search_query .'%');
            });
        })
        ->filterByJenisPolsus($data['jenis_polsus'])
        ->when($data['attribute'] == 'blm', function ($q) {
            $q->where('jenjang_diklat', 'belum');
        })
        ->when($data['attribute'] == 'sdh', function ($q) use ($data) {
            $q->filterByJenjangDiklat($data['jenjang_diklat']);
        })
        ->get(['nama', 'pangkat', 'golongan', 'jabatan', 'no_nip', 'no_kta', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'detail_alamat', 'instansi_id', 'kategori']);

        $this->page = 15;
        $result = $this->pagination($query->toArray(), $request);

        return response()->json($result);
    }
}
