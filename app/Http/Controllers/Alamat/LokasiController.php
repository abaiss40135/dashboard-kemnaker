<?php

namespace App\Http\Controllers\Alamat;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Kecamatan;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class LokasiController extends Controller
{
    public function select2()
    {
        $query = Kecamatan::query();
        $query->when(request('q'), function ($query) {
            $query->where(function ($query){
                $query->where('name', 'ilike', '%' . request('q') . '%')
                    ->orWhereHas('kota', function ($query) {
                        $query->where('name', 'ilike', '%' . request('q') . '%');
                    })
                    ->orWhereHas('kota.provinsi', function ($query) {
                        $query->where('name', 'ilike', '%' . request('q') . '%');
                    });
            });
        });
        if (request()->wantsJson()){
            return response()->json($this->mapForSelect2($query->get()));
        }
        return $this->mapForSelect2($query->get());
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function domisili()
    {
        $count = 0;
        $endCount = 0;
        $page = request()->get('page', 1);
        $query = Desa::query();
        $query->when(request('name'), function ($query) {
            $query->where(function ($query){
                $query->where('name', 'ilike', '%' . request('name') . '%')
                    ->orWhereHas('kecamatan', function ($query) {
                        $query->where('name', 'ilike', '%' . request('name') . '%');
                    })
                    ->orWhereHas('kecamatan.kota', function ($query) {
                        $query->where('name', 'ilike', '%' . request('name') . '%');
                    })
                    ->orWhereHas('kecamatan.kota.provinsi', function ($query) {
                        $query->where('name', 'ilike', '%' . request('name') . '%');
                    });
            });
        });


        if (request()->has('page')){
            $resultCount = 10;
            $offset = ($page - 1)  * $resultCount;

            $count = $query->count();
            $tempResult  = $query->skip($offset)->take($resultCount)->get();
            $endCount   = $offset + $resultCount;
        } else {
            $tempResult  =  $query->get();
        }
        $results = $this->mapForSelect2($tempResult);

        if (request()->has('page')){
            return [
                'results' => $results,
                'pagination' => [
                    'more' => $count > $endCount
                ]
            ];
        }

        if (request()->wantsJson()){
            return response()->json($results);
        }
        return $results;
    }

    private function mapForSelect2($data)
    {
        return $data->map(function ($item) {
            return [
                'id' => $item->code,
                'text' => $item->long_location_name
            ];
        });
    }

    public function getAlamatLengkap($kode_daerah)
    {
        return extractLocation($kode_daerah);
    }
}
