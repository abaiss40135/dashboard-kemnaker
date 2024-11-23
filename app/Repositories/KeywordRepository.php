<?php


namespace App\Repositories;


use App\Models\Dds_warga;
use App\Models\Deteksi_dini;
use App\Models\Keyword;
use App\Models\LaporanPublik;
use App\Models\Problem_solving;
use App\Repositories\Abstracts\KeywordRepositoryAbstract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;

class KeywordRepository extends KeywordRepositoryAbstract
{

    public $limit = 0;
    public $popularLimit = 30;

    public function model()
    {
        return Keyword::class;
    }

    public function filterData(array $filter, $query)
    {
        if (!empty($filter['is_valid'])) {
            $valid = $filter['is_valid'] || $filter['is_valid'] == "true";
            $query->where('is_valid', $valid);
        }
        if (!empty($filter['keyword'])) {
            $query->where('keyword', 'ilike', $filter['keyword'] . '%');
        }
        if (!empty($filter['keyword_pencarian']) || !empty($filter['search'])) {
            $searchQuery = null;
            if (!empty($filter['keyword_pencarian'])) {
                $searchQuery = $filter['keyword_pencarian'];
            }
            if (!empty($filter['search']) && !is_array($filter['search'])) {
                $searchQuery = $filter['search'];
            }
            if (!is_null($searchQuery)) {
                $query->withAndWhereHas('laporanInformasis', function ($query) use ($searchQuery) {
                    $query->whereHas('form', function ($query) use ($searchQuery) {
                        if ($query->getModel()->getTable() === LaporanPublik::query()->getModel()->getTable()) {
                        } else {
                            $query->where('penulis', 'ilike', '%' . $searchQuery . '%');
                            if (isset(Lang::get('abbreviation')[strtoupper($searchQuery)])) {
                                $query->orWhere('polda', '=', Lang::get('abbreviation')[strtoupper($searchQuery)]);
                            }
                        }
                    })
                    ->orWhereHas('keywords', function ($query) use ($searchQuery) {
                        $query->where('keyword', 'ilike', '%' . $searchQuery . '%');
                    })
                    ->orWhere('bidang', '=', strtolower($searchQuery));
                })->withAndorWhereHas('ddsWargas', function ($query) use ($searchQuery) {
                    $query->where('penulis', 'ilike', '%' . $searchQuery . '%')
                        ->orWhereHas('keywords', function ($query) use ($searchQuery) {
                            $query->where('keyword', 'ilike', '%' . $searchQuery . '%');
                        });
                    if (isset(Lang::get('abbreviation')[strtoupper($searchQuery)])) {
                        $query->orWhere('polda', '=', Lang::get('abbreviation')[strtoupper($searchQuery)]);
                    }
                })->withAndorWhereHas('deteksiDinis', function ($query) use ($searchQuery) {
                    $query->where('penulis', 'ilike', '%' . $searchQuery . '%')
                        ->orWhereHas('keywords', function ($query) use ($searchQuery) {
                            $query->where('keyword', 'ilike', '%' . $searchQuery . '%');
                        });
                    if (isset(Lang::get('abbreviation')[strtoupper($searchQuery)])) {
                        $query->orWhere('polda', '=', Lang::get('abbreviation')[strtoupper($searchQuery)]);
                    }
                })->withAndorWhereHas('problemSolvings', function ($query) use ($searchQuery) {
                    $query->where('penulis', 'ilike', '%' . $searchQuery . '%')
                        ->orWhereHas('keywords', function ($query) use ($searchQuery) {
                            $query->where('keyword', 'ilike', '%' . $searchQuery . '%');
                        });
                    if (isset(Lang::get('abbreviation')[strtoupper($searchQuery)])) {
                        $query->orWhere('polda', '=', Lang::get('abbreviation')[strtoupper($searchQuery)]);
                    }
                });
            }
        }

        /** Filter laporan berdasarkan provinsi, ambil laporannya */
        if (!empty($filter['provinsi'])) {
            $query->withAndWhereHas('laporanInformasis', function ($query) use ($filter) {
                $query->whereHas('form', function ($query) use ($filter) {
                    $query->where('polda', '=', Lang::get('abbreviation')[strtoupper($filter['provinsi'])]);
                });
            })->withAndorWhereHas('ddsWargas', function ($query) use ($filter) {
                $query->where('polda', '=', Lang::get('abbreviation')[strtoupper($filter['provinsi'])]);
            })->withAndorWhereHas('deteksiDinis', function ($query) use ($filter) {
                $query->where('polda', '=', Lang::get('abbreviation')[strtoupper($filter['provinsi'])]);
            })->withAndorWhereHas('problemSolvings', function ($query) use ($filter) {
                $query->where('polda', '=', Lang::get('abbreviation')[strtoupper($filter['provinsi'])]);
            });
        }

        if (!empty($filter['bidang'])) {
            $query->withAndWhereHas('laporanInformasis', function ($query) use ($filter) {
                $query->where('bidang', '=', strtolower($filter['bidang']));
            });
        }
        if (!empty($filter['jenis_laporan'])) {
            $query->withAndWhereHas('laporanInformasis', function ($query) use ($filter) {
                $jenis = Dds_warga::class;
                switch ($filter['jenis_laporan']) {
                    case 'DDS Warga':
                        $jenis = Dds_warga::class;
                        break;
                    case 'Deteksi Dini':
                        $jenis = Deteksi_dini::class;
                        break;
                    case 'Problem Solving':
                        $jenis = Problem_solving::class;
                        break;
                    case 'Laporan Publik':
                        $jenis = LaporanPublik::class;
                        break;
                }
                $query->where('form_type', '=', $jenis);
            });
        }
        if (!empty($filter['today']) && $filter['today'] == 'true') {
            $query->whereDate('updated_at', now());
        }
        if (!empty($filter['start_date'])){
            $query->whereDate('updated_at', '>=', $filter['start_date']);
        }
        if (!empty($filter['end_date'])){
            $query->whereDate('updated_at', '<=', $filter['end_date']);
        }
        if (!empty($filter['tanggal'])) {
            $date = Carbon::createFromFormat('d-m-Y', $filter['tanggal'])->format('Y-m-d');
            $query->withAndWhereHas('laporanInformasis', function ($query) use ($filter, $date) {
                $query->whereHas('form', function ($query) use ($filter, $date) {
                    $query->whereDate('updated_at', $date);
                });
            })->withAndorWhereHas('ddsWargas', function ($query) use ($filter, $date) {
                $query->where('tanggal', $date);
            })->withAndorWhereHas('deteksiDinis', function ($query) use ($filter, $date) {
                $query->where('tanggal_mendapatkan_informasi', $date);
            })->withAndorWhereHas('problemSolvings', function ($query) use ($filter, $date) {
                $query->where('tanggal_kejadian', $date);
            });
        }
    }
}
