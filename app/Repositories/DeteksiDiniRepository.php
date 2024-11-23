<?php


namespace App\Repositories;


use App\Models\Deteksi_dini;
use App\Repositories\Abstracts\DeteksiDiniRepositoryAbstract;
use Illuminate\Support\Carbon;

class DeteksiDiniRepository extends DeteksiDiniRepositoryAbstract
{

    public function model()
    {
        return Deteksi_dini::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['user_id'])){
            $query->where('user_id', $filter['user_id']);
        }
        if (!empty($filter['nama_narasumber'])) {
            $query->where('nama_narasumber', 'ilike', '%' . $filter['nama_narasumber'] . '%');
        }
        if (!empty($filter['bulan'])) {
            try {
                $date = Carbon::createFromFormat('Y-m', $filter['bulan']);
            } catch (\Exception $e) {
                $date = Carbon::now();
            }

            $query->whereBetween('created_at', [
                $date->startOfMonth()->format('Y-m-d H:i:s'),
                $date->endOfMonth()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
