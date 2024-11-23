<?php

namespace App\Services;


use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Laporan\ProgramPemerintah\PemungutanSuaraCapres2024;
use App\Models\Provinsi;
use Yajra\DataTables\Facades\DataTables;

class LaporanPemungutanSuaraCapres2024Service
{
    public function getDatatable()
    {
        $role   = auth()->user()->role();
        $query  = PemungutanSuaraCapres2024::query()
            ->when($role != 'administrator', function ($query){
                return $query->where('user_id', auth()->user()->id);
            });

        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '<a href="' . route('program-pemerintah.laporan-pemungutan-suara-capres.edit', $collection->id) . '" data-id="' . $collection->id . '" class="btn btn-sm btn-warning my-0"><i class="far fa-edit"></i></a>';
                $button .= '<a href="#" data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete my-2"><i class="far fa-trash-alt"></i></a>';
//                $button .= '<button onclick="confirmSatuanPersonel('. $collection->id .')"  class="btn btn-sm btn-info "><i class="fa s fa-file-alt text-white"></i></button>';
                return $button;
            })
            ->addColumn('lokasi_pemungutan_suara', function ($collection) {
                return $collection->provinsi . ', ' . $collection->kabupaten . ', ' . $collection->kecamatan . ', ' . $collection->kelurahan;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(array $data)
    {
        try {
            unset($data['_token']);
            $data['user_id'] = auth()->user()->id;
            $namaDesa = $data['kelurahan_kode'];

            $data['provinsi_kode'] = Provinsi::firstWhere('name', 'ilike', $data['provinsi_kode'])->code;

            $data['kabupaten_kode'] = Kota::where([
                ['name', 'ilike', $data['kabupaten_kode']],
                ['province_code', '=', $data['provinsi_kode']]
            ])->first()->code;

            $data['kecamatan_kode'] = Kecamatan::where([
                ['name', 'ilike', $data['kecamatan_kode']],
                ['city_code', '=', $data['kabupaten_kode']]
            ])->first()->code;

            $data['kelurahan_kode'] = Desa::where([
                ['name', 'ilike', $data['kelurahan_kode']],
                ['district_code', '=', $data['kecamatan_kode']]
            ])->first()->code;

            if(PemungutanSuaraCapres2024::where('kelurahan_kode', $data['kelurahan_kode'])->exists()){
                $data = PemungutanSuaraCapres2024::firstWhere('kelurahan_kode', $data['kelurahan_kode'])->load('user.personel');
                throw new \Exception('Laporan Pemungutan Suara Capres 2024 untuk wilayah desa/kelurahan ' . $namaDesa . ' sudah ada!<br><br> Silahkan hubungi Bhabinkamtibmas a.n. '. $data->user->personel->nama .' (<a target="_blank" href="tel:'. $data->user->personel->handphone .'">'. $data->user->personel->handphone .'</a>) yang menginputkan data tersebut');
            }

            $laporan = PemungutanSuaraCapres2024::create($data);
        } catch (\Exception $e) {
            $laporan = $e;
        }

        return $laporan;
    }

    public function show($id)
    {
        return PemungutanSuaraCapres2024::query()
            ->find($id);
    }

    public function update(array $data, $id)
    {
        try {
            $data['user_id'] = auth()->user()->id;
            $namaDesa = $data['kelurahan_kode'];

            $data['provinsi_kode'] = Provinsi::firstWhere('name', 'ilike', $data['provinsi_kode'])->code;
            $data['kabupaten_kode'] = Kota::where([
                ['name', 'ilike', $data['kabupaten_kode']],
                ['province_code', '=', $data['provinsi_kode']]
            ])->first()->code;

            $data['kecamatan_kode'] = Kecamatan::where([
                ['name', 'ilike', $data['kecamatan_kode']],
                ['city_code', '=', $data['kabupaten_kode']]
            ])->first()->code;

            $data['kelurahan_kode'] = Desa::where([
                ['name', 'ilike', $data['kelurahan_kode']],
                ['district_code', '=', $data['kecamatan_kode']]
            ])->first()->code;

            if(PemungutanSuaraCapres2024::where([
                ['kelurahan_kode', '=', $data['kelurahan_kode']],
                ['id', '!=', $id],
            ])->exists()){
                throw new \Exception('Laporan Pemungutan Suara Capres 2024 untuk wilayah desa ' . $namaDesa . ' sudah ada!');
            }

            $data = PemungutanSuaraCapres2024::find($id)->update($data);
        } catch (\Exception $e) {
            $data = $e;
        }

        return $data;
    }

    public function delete($id)
    {
        $dds = PemungutanSuaraCapres2024::find($id);
        return $dds->delete();
    }
}
