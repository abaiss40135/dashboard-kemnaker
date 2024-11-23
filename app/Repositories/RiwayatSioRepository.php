<?php


namespace App\Repositories;


use App\Models\RiwayatSio;
use App\Repositories\Abstracts\RiwayatSioRepositoryAbstract;
use App\Services\StatusSioService;
use Illuminate\Support\Facades\DB;

class RiwayatSioRepository extends RiwayatSioRepositoryAbstract
{

    public function model()
    {
        return RiwayatSio::class;
    }

    public function filterData(array $filter, $query)
    {
        $role = auth()->user()->role();

        if (!empty($filter['type'])){
            $query->where('type', $filter['type']);
        }

        if ($role == 'operator_polda') {
            $query->operatorPolda(auth()->user()->personel->polda);
        }
        if ($role == 'operator_mabes_2') {
            $query->whereHas('status_terakhir', function ($query) {
                $query->operatorMabesTingkatSatu();
            })->validOrNull();
        }
        if ($role == 'operator_mabes') {
            $query->whereHas('status_terakhir', function ($query) {
                $query->operatorMabesTingkatDua();
            })
            ->valid()
            ->when(!empty($filter['validation']), function ($query) use ($filter) {
                $query->whereHas(
                    'log_statuses', fn ($q) =>
                    $q->where('status_sio_id', '>=', 5),
                    $filter['validation'] == 1 ? '>=' : '=',
                    $filter['validation'] == 2 ? 0 : 1
                );
            });
        }
        $query->where(function ($query) use ($filter, $role) {
            if (!empty($filter['status_dokumen'])) {
                switch ($filter['status_dokumen']) {
                    case 'belum':
                        if (in_array($role, ['operator_mabes', 'operator_mabes_2'])) {
                            $query->where(function ($query) use ($filter, $role) {
                                $query->whereNull('validasi_hasil_audit')
                                    ->orWhereNull('validasi_surat_rekom');
                            });
                        } elseif ($role == 'operator_polda') {
                            $query->whereHas('dokumens', function ($query) {
                                $query->where('validasi', null);
                            });
                        }
                        break;
                    case 'invalid':
                        $query->where(function ($query) use ($filter, $role) {
                            $query->whereHas('dokumens', function ($query) {
                                $query->where('berkas_pendaftaran_sio.validasi', false);
                            })->orWhere(function ($query) {
                                $query->where('validasi_hasil_audit', false)
                                    ->orWhere('validasi_surat_rekom', false);
                            });
                        });
                        break;
                    case 'valid':
                        $query->whereDoesntHave('dokumens', function ($query) {
                            $query->whereIn('berkas_pendaftaran_sio.validasi', [null, false]);
                        })->whereHas('status_terakhir', function ($query) {
                            $query->where('status_sio_id', '>', 1);
                        });
                        if (in_array($role, ['operator_mabes', 'operator_mabes_2'])) {
                            $query->where('validasi_hasil_audit', true)
                                ->where('validasi_surat_rekom', true);
                        }
                        break;
                }
            }
            if (!empty($filter['status_terakhir'])) {
                $query->whereHas('status_terakhir', function ($query) use ($filter){
                    $query->where('status_sio_id', $filter['status_terakhir']);
                });
            }
            if (!empty($filter['is_terbit']) && in_array($filter['is_terbit'], [1,2])){
                $query->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('log_status_riwayat_sio')
                        ->whereColumn('log_status_riwayat_sio.riwayat_sio_id', 'riwayat_sio.id')
                        ->where('status_sio_id', '=', StatusSioService::SIO_BARU_TERBIT);
                });
                if($filter['is_terbit'] == 2) {
                    $query->whereDoesntHave("dokumens");
                } else if ($filter['is_terbit'] == 1) {
                    $query->has('dokumens');
                }
            } else {
                $query->whereDoesntHave('status_terakhir', function ($query) {
                    $query->where('status_sio_id', '=', StatusSioService::SIO_BARU_TERBIT);
                });
            }

            $query->when($filter['jenis_tanggal'] === 'terbit',
                fn ($q) => $q->when(!empty($filter['start_date']),
                    fn ($q) => $q->whereHas('checklist',
                        fn ($q) => $q->whereDate('tgl_izin', '>=', $filter['start_date'])
                    )
                )
                ->when(!empty($filter['end_date']),
                    fn ($q) => $q->whereHas('checklist',
                        fn ($q) => $q->whereDate('tgl_izin', '<=', $filter['end_date'])
                    )
                )
            )
            ->when($filter['jenis_tanggal'] === 'pengajuan',
                fn ($q) => $q->when(!empty($filter['start_date']),
                    fn ($q) => $q->whereDate('tanggal_pengajuan', '>=', $filter['start_date'])
                )
                ->when(!empty($filter['end_date']),
                    fn ($q) => $q->whereDate('tanggal_pengajuan', '<=', $filter['end_date'])
                )
            )
            ->when($filter['jenis_tanggal'] === 'diproses',
                fn ($q) =>$q->whereHas('status_terakhir',
                    fn ($q) => $q->when(!empty($filter['start_date']),
                        fn ($q) => $q->whereDate('created_at', '>=', $filter['start_date'])
                    )
                    ->when(!empty($filter['end_date']),
                        fn ($q) => $q->whereDate('created_at', '<=', $filter['end_date'])
                    )
                )
            );

            if (!empty($filter['search'])) {
                $query->where(function ($query) use ($filter) {
                    $query->where('id_izin', $filter['search'])
                        ->orWhereHas('checklist.nib', function ($query) use ($filter) {
                            $query->where('nama_perseroan', 'ilike', "%" . $filter['search'] . "%");
                        })
                        ->orWhereHas('checklist', function ($query) use ($filter) {
                            $query->where('bidang_spesifik', 'ilike', "%" . $filter['search'] . "%");
                        })
                        ->orWhereHas('status_terakhir.user.personel', function ($query) use ($filter) {
                            $query->where('nama', 'ilike', '%' . $filter['search'] . '%');
                        });
                });
            }
            if (!empty($filter['polda'])) {
                $query->where('polda', $filter['polda']);
            };
        });
    }
}
