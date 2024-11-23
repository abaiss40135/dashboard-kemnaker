<?php

namespace App\Services\Sislap\Lapsubjar\Binpolmas\BinpolmasBaru;

use App\Helpers\Constants;
use App\Models\Personel;
use App\Models\Sislap\Lapsubjar\Binpolmas\DataFkpm;
use App\Models\Sislap\Lapsubjar\Binpolmas\DataKomunitasMasyarakat;
use App\Models\Sislap\Lapsubjar\Binpolmas\DataOrsosmas;
use App\Models\Sislap\Lapsubjar\Binpolmas\DataPranata;
use App\Models\Sislap\Lapsubjar\Binpolmas\KegiatanPetugasPolmas;
use App\Models\Sislap\Lapsubjar\Binpolmas\PembinaPolmas;
use App\Models\Sislap\Lapsubjar\Binpolmas\PetugasPolmas;
use App\Models\Sislap\Lapsubjar\Binpolmas\SupervisorPolmas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ChartDataBinpolmasService
{
    // for model, if the value is array, then the first index is the model, and the second index is the selectRaw for chart data
    private $model = [
        'data_fkpm_kawasan' => DataFkpm::class,
        'data_fkpm_wilayah' => DataFkpm::class,
        'data_pranata' => DataPranata::class,
        'data_orsosmas' => DataOrsosmas::class,
        'data_komunitas_masyarakat' => DataKomunitasMasyarakat::class,
        'petugas_polmas_kawasan' => [
            PetugasPolmas::class,
            'sum(jumlah_petugas_kawasan) as total',
        ],
        'petugas_polmas_wilayah' => [
            PetugasPolmas::class,
            'sum(jumlah_petugas_wilayah) as total',
        ],
        'supervisor_polmas' => [
            SupervisorPolmas::class,
            'sum(jumlah_supervisor_polres) + sum(jumlah_supervisor_polsek) as total',
        ],
        'pembina_polmas' => [
            PembinaPolmas::class,
            'sum(jumlah_pembina_polda) + sum(jumlah_pembina_polres) as total',
        ],
        'kegiatan_petugas_polmas_sambang' => [
            KegiatanPetugasPolmas::class,
            'sum(sambang) as total',
        ],
        'kegiatan_petugas_polmas_pemecahan_masalah_sosial' => [
            KegiatanPetugasPolmas::class,
            'sum(pemecahan_masalah) as total',
        ],
        'kegiatan_petugas_polmas_laporan_informasi' => [
            KegiatanPetugasPolmas::class,
            'sum(laporan_informasi) as total',
        ],
        'kegiatan_petugas_polmas_penaganan_perkara_ringan' => [
            KegiatanPetugasPolmas::class,
            'sum(penanganan_perkara_ringan) as total',
        ],
    ];

    private function queryModel($model)
    {
        $personel = auth()->user() ? auth()->user()->personel : null;

        return $model::query()
//            ->when($model === PetugasPolmas::class, function ($q) {
//                $q->thisMonth();
//            })
            ->when(auth()->user() && auth()->user()->haveRoleID(User::BINPOLMAS_POLDA), function ($q) {
                $q->where('polda', auth()->user()->personel->polda);
            })
            ->when(auth()->user() && auth()->user()->haveRoleID(User::BINPOLMAS_POLRES), function ($q) {
                $q->where('polres', auth()->user()->personel->polres);
            })->when(auth()->user() && auth()->user()->haveRole('operator_bagopsnalev_polres'), fn ($q) =>
            // kode_satuan is not nullable & required column,
            // 'where null' clause return no data.

            $personel
            && empty($personel->satuan2)
                ? $q->whereNull('kode_satuan')
                : $q->where('kode_satuan', 'like', $personel->kode_satuan.'%')
            )
            ->when(auth()->user() && auth()->user()->haveRole('operator_bagopsnalev_polda'), fn ($q) => empty($personel->satuan1)
                    ? $q->whereNull('kode_satuan')
                    : $q->where('kode_satuan', 'like', $personel->kode_satuan.'%')
                        ->whereHas('approvals', fn ($q) => $q->where(fn ($q) => $q->whereNull('is_approve')
                                ->orWhere('is_approve', true)
                        )
                        )
            )
            ->when(auth()->user() && auth()->user()->haveRole('operator_bagopsnalev_mabes'), fn ($q) => $q->whereHas('approval', fn ($q) => $q->whereIn('level', ['mabes', 'polda'])
                    ->where(fn ($q) => $q->whereNull('is_approve')
                        ->orWhere('is_approve', true)
                    )
            ))
            ->when(auth()->user() && auth()->user()->haveRole(['administrator', 'pimpinan_polri']), fn ($q) =>
                /*
                 * Temporary fix for administrator role
                 * can see laporan who doenst have approval mabes
                 */
//                $this->sislapService
                $q->whereHas('approval', fn ($q) =>
                    $q->whereIn('level', ['mabes', 'polda', 'administrator', 'pimpinan_polri'])
                    ->where(fn ($q) =>
                        $q->whereNull('is_approve')
                            ->orWhere('is_approve', true)
                            ->orWhere('is_approve', false)
                    )
                )
            );
    }

    private function countAllModel()
    {
        $indexNomor = 1;
        $alphaPetugasPolmas = 'A';
        $alphaKegiatanPolmas = 'A';

        $data = [];
        $dataRwPetugasPolmas = [];
        foreach ($this->model as $key => $model) {
            if ($key === 'petugas_polmas_wilayah') {
                $dataRwPetugasPolmas[] = $this->queryModel($model[0])->sum('jumlah_rw');
            } else {
                $dataRwPetugasPolmas[] = null;
            }

            if (is_array($model)) {
                $result = $this->queryModel($model[0])
                                ->selectRaw($model[1])
                                ->first()
                                ->total ?? 0;

                if (str_contains($key, 'kegiatan')) {
                    if ($indexNomor !== 9) { // nomor kegiatan polmas adalah 9, maka harus disamakan
                        ++$indexNomor;
                    }

                    $data[$indexNomor.$alphaKegiatanPolmas.'._'.$key] = $result;
                    $alphaKegiatanPolmas = strtoupper(chr(ord($alphaKegiatanPolmas) + 1));
                } elseif (str_contains($key, 'petugas_polmas')) {
                    $data[$indexNomor.$alphaPetugasPolmas.'._'.$key] = $result;
                    $alphaPetugasPolmas = strtoupper(chr(ord($alphaPetugasPolmas) + 1));
                } else {
                    $data[++$indexNomor.'._'.$key] = $result;
                }

                continue;
            } elseif (str_contains($key, 'data_fkpm')) {
                $type = explode('_', $key)[2];
                $result = $this->queryModel($model)->where('type', $type)->count();

                $data[$indexNomor++.'._'.$key] = $result;
                continue;
            }

            $data[$indexNomor++.'._'.$key] = $this->queryModel($model)->count();
        }

        return [$data, $dataRwPetugasPolmas];
    }

    public function tahap1()
    {
        return $this->countAllModel();
    }

    public function tahap2($type)
    {
        $model = is_array($this->model[$type]) ? $this->model[$type][0] : $this->model[$type];

        $data = [];

        if ($type === 'pembina_polmas') {
            $query = $this->queryModel($model)
                ->groupBy('polda')
                ->select('polda')
                ->selectRaw('sum(jumlah_pembina_polda) as jumlah_pembina_polda')
                ->selectRaw('sum(jumlah_pembina_polres) as jumlah_pembina_polres')
                ->get();

            $data = $this->removePoldaWord($query->toArray());

            // sorting desc
            uasort($data, function ($a, $b) {
                return $b['jumlah_pembina_polda'] - $a['jumlah_pembina_polda'];
            });

            $data = array_map(function ($item) {
                return [
                    $item['jumlah_pembina_polda'],
                    $item['jumlah_pembina_polres'] + $item['jumlah_pembina_polda'],
                ];
            }, $data);
        } else {
            $query = $this->queryModel($model)
                ->groupBy('polda')
                ->select('polda')
                ->when(is_array($this->model[$type]), function ($q) use ($type) {
                    $q->selectRaw($this->model[$type][1]);
                })
                ->when(str_contains($type, 'data_fkpm'), function ($q) use ($type) {
                    $fkpm_type = explode('_', $type)[2];
                    $q->where('type', $fkpm_type)->selectRaw('count(*) as total');
                })
                ->when(array_search($type, ['data_pranata', 'data_orsosmas', 'data_komunitas_masyarakat']) !== false, function ($q) {
                    $q->selectRaw('count(*) as total');
                })
                ->get();

            $rawArrayDataModel = $query->toArray();
            $data = $this->removePoldaWord($rawArrayDataModel);

            uasort($data, function ($a, $b) {
                return $b - $a;
            });

            if ($type === 'petugas_polmas_wilayah') {
                $jumlahRwPolmasWilayahRaw = $this->queryModel($model)
                    ->groupBy('polda')
                    ->selectRaw('sum(jumlah_rw) as jumlah_rw, polda')
                    ->pluck('jumlah_rw', 'polda')
                    ->toArray();

                $jumlahRwPolmasWilayah = $this->removePoldaWord($jumlahRwPolmasWilayahRaw);

                $persentaseCapaianPetugasPolmasRw = array_map(function ($polda, $totalPetugasPolmas) use ($jumlahRwPolmasWilayah) {
                    $presentase = round($totalPetugasPolmas / $jumlahRwPolmasWilayah[$polda] * 100);
                    return ' (' . $presentase . '%)';
                }, array_keys($data), $data);

                $persentaseCapaianPetugasPolmasRw = array_combine(array_keys($data), $persentaseCapaianPetugasPolmasRw);

                $result = [];
                $tempjumlahRwPolmasWilayah = [];

                foreach ($data as $key => $value) {
                    $result[$key.$persentaseCapaianPetugasPolmasRw[$key]] = $value;
                    $tempjumlahRwPolmasWilayah[] = $jumlahRwPolmasWilayah[$key];
                }

                $jumlahRwPolmasWilayah = $tempjumlahRwPolmasWilayah;
                $data = $result;
            }
        }

        return isset($jumlahRwPolmasWilayah) ? [$data, $jumlahRwPolmasWilayah] : $data;
    }

    public function tahap3($polda, $type)
    {
        // because petugas polmas has unique type: POLDA/POLRES (200%)
        // so we need explode the type and get POLDA/POLRES on the first index
        if ($type === 'petugas_polmas_wilayah') {
            $polda = explode(' (', $polda)[0];
        }

        // special case on polda metro jaya
        if ($polda === 'PMJ') {
            $polda = 'POLDA METRO JAYA';
        }

        $model = is_array($this->model[$type]) ? $this->model[$type][0] : $this->model[$type];

        $data = [];

        // special case on supervisor polmas
        if ($type === 'supervisor_polmas') {
            $query = $this->queryModel($model)
                ->where('polda', 'ilike', '%'.$polda.'%')
                ->groupBy('polres')
                ->select('polres')
                ->selectRaw('sum(jumlah_supervisor_polres) as jumlah_supervisor_polres')
                ->selectRaw('sum(jumlah_supervisor_polsek) as jumlah_supervisor_polsek')
                ->get();

            foreach ($query->toArray() as $item) {
                $data[$item['polres']] = [
                    $item['jumlah_supervisor_polres'],
                    $item['jumlah_supervisor_polsek'],
                ];
            }

            //            uasort($data, function ($a, $b) {
            //                return $b - $a;
            //            });
        }
        //        else if($type === 'pembina_polmas') {
        //            $query = $this->queryModel($model)
        //                ->where('polda', 'ilike', '%'. $polda .'%')
        //                ->groupBy('polres')
        //                ->select('polres')
        //                ->selectRaw('sum(jumlah_pembina_polres) as jumlah_pembina_polres')
        //                ->selectRaw('sum(jumlah_pembina_polda) as jumlah_pembina_polda')
        //                ->get();
        //
        //            foreach($query->toArray() as $item)
        //            {
        //                $data[$item['polres']] = [
        //                    $item['jumlah_pembina_polres'],
        //                    $item['jumlah_pembina_polda'],
        //                ];
        //            }
        //        }
        else {
            $query = $this->queryModel($model)
                ->where('polda', 'ilike', '%'.$polda.'%')
                ->groupBy('polres')
                ->select('polres')
                ->when(is_array($this->model[$type]) && $type !== 'pembina_polmas', function ($q) use ($type) {
                    $q->selectRaw($this->model[$type][1]);
                })
                ->when($type === 'pembina_polmas', function ($q) {
                    $q->selectRaw('sum(jumlah_pembina_polres) as total');
                })
                ->when(str_contains($type, 'data_fkpm'), function ($q) use ($type) {
                    $fkpm_type = explode('_', $type)[2];
                    $q->where('type', $fkpm_type)->selectRaw('count(*) as total');
                })
                ->when(array_search($type, ['data_pranata', 'data_orsosmas', 'data_komunitas_masyarakat']) !== false, function ($q) {
                    $q->selectRaw('count(*) as total');
                })
                ->get();

            foreach ($query->toArray() as $item) {
                $data[$item['polres']] = $item['total'];
            }

            uasort($data, function ($a, $b) {
                return $b - $a;
            });
        }

        // special case on petugas_polmas_wilayah, collection total sum of data jumlah_rw
        if ($type === 'petugas_polmas_wilayah') {
            // istilah data kembar merujuk pada chart data binpolmas yang lebih dari 1,
            $jumlahRwPolmasWilayah = $this->queryModel($model)
                ->where('polda', 'ilike', '%'.$polda.'%')
                ->groupBy('polres')
                ->selectRaw('sum(jumlah_rw) as jumlah_rw, polres')
                ->get()
                ->pluck('jumlah_rw', 'polres')
                ->toArray();

            $persentaseCapaianPetugasPolmasRw = array_map(function ($total, $polres) use ($jumlahRwPolmasWilayah) {
                return ' ('.round($total / $jumlahRwPolmasWilayah[$polres] * 100).'%)';
            }, $data, array_keys($data));

            $persentaseCapaianPetugasPolmasRw = array_combine(array_keys($data), $persentaseCapaianPetugasPolmasRw);

            $result = [];
            $tempjumlahRwPolmasWilayah = [];
            foreach ($data as $key => $value) {
                $result[$key.$persentaseCapaianPetugasPolmasRw[$key]] = $value;
                $tempjumlahRwPolmasWilayah[] = $jumlahRwPolmasWilayah[$key];
            }

            $jumlahRwPolmasWilayah = $tempjumlahRwPolmasWilayah;
            $data = $result;
        }

        return isset($jumlahRwPolmasWilayah) ? [$data, $jumlahRwPolmasWilayah] : $data;
    }

    // not used
    public function tahap4($polres, $type)
    {
        $model = $this->model[$type];

        $query = $this->queryModel($model)
            ->where('polres', $polres)
            ->when($type === 'data_fkpm', function ($q) {
                $q->selectRaw('SUM(CASE WHEN type = \'wilayah\' THEN 1 ELSE 0 END) AS total_fkpm_wilayah,
              SUM(CASE WHEN type = \'kawasan\' THEN 1 ELSE 0 END) AS total_fkpm_kawasan');
            })
            ->when($type === 'petugas_polmas', function ($q) {
                $q->selectRaw('sum(jumlah_petugas_kawasan) as total_petugas_kawasan, sum(jumlah_petugas_wilayah) as total_petugas_wilayah');
            })
            ->when($type === 'supervisor_polmas', function ($q) {
                $q->selectRaw('sum(jumlah_supervisor_polres) as total_supervisor_polres, sum(jumlah_supervisor_polsek) as total_supervisor_polsek');
            })
            ->when($type === 'pembina_polmas', function ($q) {
                $q->selectRaw('sum(jumlah_pembina_polda) as total_pembina_polda, sum(jumlah_pembina_polres) as total_pembina_polres');
            })
            ->when($type === 'kegiatan_petugas_polmas', function ($q) {
                $q->selectRaw('sum(sambang) as total_sambang, sum(pemecahan_masalah) as total_pemecahan_masalah, sum(laporan_informasi) as total_laporan_informasi, sum(penanganan_perkara_ringan) as total_penanganan_perkara_ringan');
            })
            ->first();

        $data = $query->toArray();
        unset($data['need_approve']);
        unset($data['approval']);

        if (array_key_exists('lampiran_url', $data)) {
            unset($data['lampiran_url']);
        }

        return $data;
    }

    public function getTaggedMap(array $request)
    {
        return Cache::remember((auth()->user()->personel->kode_satuan ?? auth()->user()->id) . json_encode(request()->all()) . 'dashboard.dashboard-binpolmas.tagged-map.', defaultCacheTime(6 * Constants::CACHE1HOUR), function () use ($request) {
            return Personel::whereHas('user', fn($u) => (
                $u->whereNotNull('last_login_at')->whereHas('roles', fn($r) => (
                    $r->where('id', User::BINPOLMAS_POLDA)
                ))
            ))
                ->pluck('satuan1')
                ->map(function ($satuan1, $key) {
                    $polda = Str::beforeLast($satuan1, '-');
                    return Constants::MAP_PATH[Str::after($polda, 'POLDA ')] ?? null;
                })->filter()->all();
        });
    }

    public function dataOperatorPolresLogin($polda)
    {
        $query = User::with('personel')->isOperatorBinpolmasPolres()
            ->whereHas('personel', fn($q) => $q->where('satuan1', 'ilike', '%' . $polda . '%'));
        $list_operator = $query->get()
                        ->map(function($q) {

                            return [
                                'nama' => $q->personel->nama,
                                'nrp' => $q->nrp,
                                'polres' => $q->personel->polres,
                                'no_hp' => $q->personel->handphone,
                                'status_login' => isset($q->last_login_at),
                                'last_login_at' => isset($q->last_login_at) ? Carbon::parse($q->last_login_at)?->format('d F Y H:i') : '-',
                            ];
                        });

        $totalOperatorPolresLogin = $query->whereNotNull('last_login_at')->count();

        if($totalOperatorPolresLogin > 0) {
            $presentaseLoginOperatorPolres = count($list_operator) / $totalOperatorPolresLogin * 100;
        } else {
            $presentaseLoginOperatorPolres = 0;
        }

        $data_operator_polda = User::with('personel')->isOperatorBinpolmas()
                                ->whereHas('personel', fn($q) => $q->where('satuan1', 'ilike', '%' . $polda . '%'))
                                ->first();

        return [
            'list_operator' => $list_operator,
            'data_operator_polda' => !isset($data_operator_polda) ? 'Polda ini belum memiliki Operator Binpolmas tingkat Polda' : [
                'nama' => $data_operator_polda?->personel?->nama ?? '-',
                'nrp' => $data_operator_polda?->nrp ?? '-',
                'pangkat' => $data_operator_polda?->personel?->pangkat ?? '-',
                'jabatan' => $data_operator_polda?->personel?->jabatan ?? '-',
                'no_hp' => $data_operator_polda?->personel?->handphone ?? '-',
            ],
            'polda' => $polda,
            'presentase_login_operator_polres' => $presentaseLoginOperatorPolres,
        ];
    }

    private function removePoldaWord($data)
    {
        $result = [];
        foreach ($data as $key => $item) {
            try {
                if(!is_array($item)) {
                    $item = [
                        'polda' => $key,
                        'total' => $item
                    ];
                }

                if(!str_contains($item['polda'], 'POLDA')) {
                    continue;
                }

                if (is_int($key)) {
                    $key = $item['polda'];
                }

                if ($key === 'POLDA METRO JAYA') {
                    $polda = 'PMJ';
                } else {
                    $polda = str_replace('POLDA ', '', $key);

                    $abbr = include __DIR__
                        .DIRECTORY_SEPARATOR.'..'
                        .DIRECTORY_SEPARATOR.'..'
                        .DIRECTORY_SEPARATOR.'..'
                        .DIRECTORY_SEPARATOR.'..'
                        .DIRECTORY_SEPARATOR.'..'
                        .DIRECTORY_SEPARATOR.'..'
                        .DIRECTORY_SEPARATOR.'resources'
                        .DIRECTORY_SEPARATOR.'lang'
                        .DIRECTORY_SEPARATOR.'id'
                        .DIRECTORY_SEPARATOR.'abbreviation.php';

                    if (array_key_exists($polda, $abbr)) {
                        $polda = $abbr[$polda];
                    }
                }

                if (array_key_exists($polda, $result)) {
                    $result[$polda] = (is_array($item) && array_key_exists('total', $item)) ? $result[$polda] + $item['total'] : $item;
                } else {
                    $result[$polda] = (is_array($item) && array_key_exists('total', $item)) ? $item['total'] : $item;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $result;
    }
}
