<?php


namespace App\Services;


use App\Models\Giat\DDSTempatUsaha;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class DDSTempatUsahaService implements Interfaces\DDSTempatUsahaServiceInterface
{

    public function getDatatable()
    {
        $role   = auth()->user()->role();
        $query  = DDSTempatUsaha::query()
                                ->when($role != 'administrator', function ($query){
                                    return $query->where('user_id', auth()->user()->id);
                                });

        return DataTables::eloquent($query)
            ->addColumn('action', function ($collection) {
                $button = '<a href="' . route('dds.tempat-usaha.edit', $collection->id) . '" data-id="' . $collection->id . '" class="btn btn-sm btn-warning my-0"><i class="far fa-edit"></i></a>';
                $button .= '<a href="#" data-id="' . $collection->id . '" class="btn btn-sm btn-danger btn-delete my-2"><i class="far fa-trash-alt"></i></a>';
                $button .= '<button onclick="confirmSatuanPersonel('. $collection->id .')"  class="btn btn-sm btn-info "><i class="fa s fa-file-alt text-white"></i></button>';
                $button .= '<a href="' . route('dds.tempat-usaha.create', ['dds_tempat_usaha_id' => $collection->id]) . '" data-id="' . $collection->id . '" class="btn btn-sm btn-primary mt-2"><i class="fas fa-user-plus text-white" style="font-size : 10px"></i></a>';
                return $button;
            })
            ->addColumn('jam_kerja', function ($collection) {
                return $collection->jam_kerja;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function store(array $data)
    {
        $karyawan = Arr::only($data, ['karyawan']);
        $tempat_usaha = array_merge(Arr::except($data, ['penanggung_jawab', 'karyawan']), ['user_id' => auth()->user()->id]);
        $penanggung_jawab = Arr::only($data, ['penanggung_jawab']);

        $DDS = new DDSTempatUsaha();
        $DDS->fill($tempat_usaha);
        $DDS->save();

        $DDS->karyawans()->createMany($karyawan['karyawan']);
        $DDS->penanggung_jawabs()->createMany($penanggung_jawab['penanggung_jawab']);

        return $DDS;
    }

    public function show($id)
    {
        return DDSTempatUsaha::query()
            ->with(['karyawans', 'penanggung_jawab_usaha', 'penanggung_jawab_keamanan'])
            ->find($id);
    }

    public function update(array $data, $id)
    {
        $karyawan = Arr::only($data, ['karyawan']);
        $tempat_usaha = array_merge(Arr::except($data, ['penanggung_jawab', 'karyawan']), ['user_id' => auth()->user()->id]);
        $penanggung_jawab = Arr::only($data, ['penanggung_jawab']);

        $DDS = DDSTempatUsaha::find($id);
        $DDS->fill($tempat_usaha);
        $DDS->save();

        $DDS->karyawans()->delete();
        $DDS->karyawans()->createMany($karyawan['karyawan']);
        $DDS->penanggung_jawabs()->delete();
        $DDS->penanggung_jawabs()->createMany($penanggung_jawab['penanggung_jawab']);

        return $DDS;
    }

    public function delete($id)
    {
        $dds = DDSTempatUsaha::find($id);
        $dds->karwayans()->delete();
        $dds->penanggung_jawabs()->delete();
        return $dds->delete();
    }
}
