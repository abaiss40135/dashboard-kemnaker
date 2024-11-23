<?php


namespace App\Repositories;


use App\Models\Dds_warga;
use App\Repositories\Abstracts\DDSWargaRepositoryAbstract;
use Illuminate\Support\Carbon;

class DDSWargaRepository extends DDSWargaRepositoryAbstract
{
    public $recordPerPage = 6;

    public function model()
    {
        return Dds_warga::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['keyword_pencarian'])) {
            $query->where("keyword", 'ilike', '%' . $filter['keyword_pencarian'] . '%')
                ->orWhere("tanggal", 'ilike', '%' . $filter['keyword_pencarian'] . '%')
                ->orWhere("provinsi_kepala_keluarga", 'ilike', '%' . $filter['keyword_pencarian'] . '%')
                ->orWhere("penulis", 'ilike', '%' . $filter['keyword_pencarian'] . '%');
        }
        if (!empty($filter['user_id'])) {
            $query->where('user_id', $filter['user_id']);
        }
        if (!empty($filter['nama_kepala_keluarga'])) {
            $query->where('nama_kepala_keluarga', 'ilike', '%' . $filter['nama_kepala_keluarga'] . '%');
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
