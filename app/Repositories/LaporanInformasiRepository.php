<?php

namespace App\Repositories;

use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use App\Models\LaporanInformasi;
use App\Models\LaporanPublik;
use App\Models\Problem_solving;
use App\Repositories\Abstracts\LaporanInformasiRepositoryAbstract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class LaporanInformasiRepository extends LaporanInformasiRepositoryAbstract
{
    public $recordPerPage = 10;
    private $jenisLaporan = '';
    public $limit = 10;

    public function model()
    {
        return LaporanInformasi::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['jenis_laporan'])) {
            switch ($filter['jenis_laporan']) {
                case 'DDS Warga':
                    $this->jenisLaporan = Dds_warga::class;
                    break;
                case 'Deteksi Dini':
                    $this->jenisLaporan = Deteksi_dini::class;
                    break;
                case 'Problem Solving':
                    $this->jenisLaporan = Problem_solving::class;
                    break;
                case 'Laporan Publik':
                    $this->jenisLaporan = LaporanPublik::class;
                    break;
            }
            $query->where('form_type', $this->jenisLaporan);

            if (!empty($filter['jenis_publik'])){
                $query->whereHas('form.pengguna_publik', function ($query) use ($filter) {
                    $query->where('type', $filter['jenis_publik']);
                });
            }

            if (!empty($filter['provinsi']) || role('operator_bhabinkamtibmas_polda')) {
                $provinsi = role('operator_bhabinkamtibmas_polda') ? Lang::get('alias-polda')[auth()->user()->personel->polda] : strtoupper($filter['provinsi']);
                $query->whereHas('form', function ($query) use ($provinsi) {
                    if ($query->getModel()->getTable() === LaporanPublik::query()->getModel()->getTable()) {
                        $query->where('provinsi', $provinsi );
                    }
                });
            }
        } else {
            $query->where('form_type', '!=', LaporanPublik::class);
        }

        if (!empty($filter['bidang'])) {
            $query->where('bidang', strtolower($filter['bidang']));
        }
        if (!empty($filter['polda']) || role('operator_bhabinkamtibmas_polda')) {
            $polda = role('operator_bhabinkamtibmas_polda') ? Str::between(auth()->user()->personel->satuan1, 'POLDA ', '-') : Lang::get('abbreviation')[strtoupper($filter['polda'])];
            $query->withAndWhereHas('form', function ($query) use ($polda) {
                if ($query->getModel()->getTable() !== LaporanPublik::query()->getModel()->getTable()) {
                    $query->where('polda', $polda);
                }
            });
        }

        if (!empty($filter['keyword'])) {
            $query->whereHas('keywords', function ($query) use ($filter) {
                $query->where('keyword', 'ilike', '%' . $filter['keyword'] . '%');
            });
        }
        if (!empty($filter['tanggal'])) {
            $date = Carbon::createFromFormat('d-m-Y', $filter['tanggal']);
            $query->whereDate('created_at', $date);
        }
        if (!empty($filter['today']) && $filter['today'] == "true") {
            $query->whereDate('created_at', now());
        }
        if (!empty($filter['start_date'])) {
            $query->whereHas('form', function ($query) use ($filter) {
                $query->whereDate('tanggal', '>=', $filter['start_date']);
            });
        }
        if (!empty($filter['end_date'])) {
            $query->whereHas('form', function ($query) use ($filter) {
                $query->whereDate('tanggal', '<=', $filter['end_date']);
            });
        }
        if (!empty($filter['search'])) {
            $query->where(function ($query) use ($filter){
                $query->whereHas('form', function ($query) use ($filter) {
                    if ($query->getModel()->getTable() !== LaporanPublik::query()->getModel()->getTable()) {
                        $query->where('penulis', 'ilike', '%' . $filter['search'] . '%');
                    }
                })->orWhereHas('keywords', function ($query) use ($filter) {
                    $query->where('keyword', 'ilike', '%' . $filter['search'] . '%');
                });
            });
        }
    }
}
