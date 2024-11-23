<?php

namespace App\Http\Controllers\API\OSS;

use App\Models\Bujp;
use App\Models\OSS\DNI;
use App\Models\User;
use App\Models\FileDS;
use App\Models\OSS\NIB;
use App\Models\Provinsi;
use App\Models\RiwayatSio;
use App\Helpers\OSSConstant;
use Illuminate\Http\Request;
use App\Models\OSS\Checklist;
use App\Models\PendaftaranSio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Actions\GenerateLampiranSioAction;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

class OSSController extends Controller
{
    use FileUploadTrait;

    private $securiyKey;

    private function getSecurityKey()
    {
        $params = [
            'securityKey' => [
                "user_akses" => config('oss-api.username'),
                "pwd_akses" => config('oss-api.password'),
            ]
        ];

        $response = Http::post(config('oss-api.prod_url') . 'sendSecurityKey', $params);

        $responsendSecurityKey = $response->json('responsendSecurityKey');
        if ($response->ok()) {
            config(['oss-api.security_key' => $responsendSecurityKey['key']]);
            return $responsendSecurityKey['key'];
        } else {
            return false;
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receiveNIB(Request $request)
    {
        if ($request->hasHeader('token')) {
            $token = $request->header('token');
            if (!isset($request->dataNIB['nib']) || $request->dataNIB['nib'] === '-') {
                return response()->json([
                    'responreceiveNIB' => [
                        'status' => 2,
                        'keterangan' => 'Payloads tidak menyertakan data NIB, mohon cek kembali request anda'
                    ]
                ]);
            }
            $nib = $request->dataNIB['nib'];
            if ($token === $this->generateLocalToken($nib)) {
                $requestData = collect($request->get('dataNIB'));
                $dataNIB = $requestData->except([
                    'pemegang_saham', 'penanggung_jwb', 'legalitas',
                    'data_rptka', 'data_proyek', 'data_dni', 'data_checklist'
                ])->toArray();
                $checklists = collect($requestData->get('data_checklist'));
                DB::transaction(function () use ($dataNIB, $nib, $checklists) {
                    foreach ($checklists as $checklist) {
                        $kd_daerah = $checklist['kd_daerah'];
                        $file_izin = $checklist['file_izin'];
                        $id_izin = $checklist['id_izin'];
                        $statusTerbit = 6;

                        if (!empty($file_izin) && $file_izin !== '-') {
                            // sio manual -> terbit otomatis
                            $this->createPengajuan(
                                NIB::updateOrCreate(['nib' => $nib], $dataNIB),
                                $checklist,
                                $this->getJenisPengajuan($kd_daerah, $dataNIB['perseroan_daerah_id']),
                                $kd_daerah
                            );

                            $this->attachFileIzin($dataNIB['nib'], $id_izin, $file_izin);
                        } else {
                            $existingSio = RiwayatSio::where('id_izin', $id_izin)->first();
                            if (!empty($existingSio) && $existingSio->status?->id == $statusTerbit) {
                                $existingSio->statusSios()->detach($statusTerbit);
                                FileDS::where('id_izin', $id_izin)->delete();
                            }
                        }
                    }
                });

                $current_checklist = $checklists->where('id_izin', $dataNIB['id_izin'])->first();
                if (empty($current_checklist)) {
                    $message = 'Gagal menerima NIB, data checklist dengan id_izin ' . $dataNIB['id_izin'] . ' tidak ditemukan';
                    Log::error('OSSAPI', [
                        'type' => 'receiveNIB',
                        'nib' => $nib,
                        'payloads' => $request->all(),
                        'message' => $message
                    ]);

                    return response()->json([
                        'responreceiveNIB' => [
                            'status' => 2,
                            'keterangan' => $message
                        ]
                    ]);
                }
                if (!in_array((int)$current_checklist['id_bidang_spesifik'], OSSConstant::ACCEPTED_ID_BIDANG)) {
                    $message = 'Gagal menerima NIB, id_bidang_spesifik ' . $current_checklist['id_bidang_spesifik'] . ' tidak sesuai KBLI 80100';
                    Log::error('OSSAPI', [
                        'type' => 'receiveNIB',
                        'nib' => $nib,
                        'payloads' => $request->all(),
                        'message' => $message
                    ]);

                    return response()->json([
                        'responreceiveNIB' => [
                            'status' => 2,
                            'keterangan' => $message
                        ]
                    ]);
                }

                try {
                    DB::beginTransaction();
                    $nib = NIB::updateOrCreate(['nib' => $nib], $dataNIB);
                    //toggle status dan file_izin, handle terbit/belum terbit
                    $this->createPengajuan($nib, $current_checklist, $this->getJenisPengajuan($current_checklist['kd_daerah'], $nib['perseroan_daerah_id']), $current_checklist['kd_daerah']);

                    DB::commit();
                    /**
                     * Update data NIB
                     */
                    if ($nib->wasChanged()) {
                        DB::transaction(function () use ($requestData, $checklists, $nib) {
                            $nib->pemegangSahams()->delete();
                            $nib->penanggungJawabs()->delete();
                            $nib->legalitas()->delete();
                            $nib->rptkas()->delete();
                            $nib->proyeks()->delete();
                            $nib->dnis()->delete();
                            $nib->checklists()->delete();

                            foreach ($checklists as $data_checklist) {
                                $checklist = $nib->checklists()->create(collect($data_checklist)->except(['data_persyaratan'])->toArray());
                                if (isset($data_checklist['data_persyaratan'])) $checklist->persyaratans()->createMany($data_checklist['data_persyaratan']);
                            }

                            if ($requestData->has('pemegang_saham')) $nib->pemegangSahams()->createMany($requestData->get('pemegang_saham'));

                            if ($requestData->has('penanggung_jwb')) $nib->penanggungJawabs()->createMany($requestData->get('penanggung_jwb'));
                            if ($requestData->has('legalitas')) $nib->legalitas()->createMany($requestData->get('legalitas'));
                            foreach (collect($requestData->get('data_dni')) as $dni) {
                                $nib->dnis()->create($dni);
                            }
                            $dataRPTKA = collect($requestData->get('data_rptka'));
                            $rptka = $nib->rptkas()->create($dataRPTKA->except(['rptka_jabatan', 'rptka_negara', 'rptka_lokasi'])->toArray());
                            foreach ($dataRPTKA->get('rptka_jabatan') as $rptkaJabatan) {
                                $dataRptkaJabatan = collect($rptkaJabatan);
                                $rptkaJabatan = $rptka->rptkaJabatans()->create($dataRptkaJabatan->except('rptka_tki_pendamping')->toArray());
                                foreach ($dataRptkaJabatan->get('rptka_tki_pendamping') as $rptka_tki_pendamping) {
                                    $rptkaJabatan->rptkaTkiPendampings()->create($rptka_tki_pendamping);
                                }
                            }

                            if ($dataRPTKA->has('rptka_negara')) $rptka->rptkaNegaras()->createMany($dataRPTKA->get('rptka_negara'));
                            if ($dataRPTKA->has('rptka_lokasi')) $rptka->rptkaLokasis()->createMany($dataRPTKA->get('rptka_lokasi'));
                            foreach (collect($requestData->get('data_proyek'))->whereIn('id_proyek', $checklists->pluck('id_proyek')) as $data_proyek) {
                                $proyek = $nib->proyeks()->create(collect($data_proyek)->except(['data_lokasi_proyek', 'data_lokasi_proyek'])->toArray());
                                if (isset($data_proyek['data_lokasi_proyek'])){
                                    foreach (collect($data_proyek['data_lokasi_proyek'])->filter(function ($value, $key) {
                                        return $value['id_proyek_lokasi'] !== '-';
                                    }) as $data_lokasi_proyek) {
                                        $lokasiProyek = $proyek->lokasiProyeks()->create(collect($data_lokasi_proyek)->except(['data_posisi_proyek'])->toArray());
                                        if (isset($data_lokasi_proyek['data_posisi_proyek'])) $lokasiProyek->posisiProyeks()->createMany($data_lokasi_proyek['data_posisi_proyek']);
                                    }
                                }
                                if (isset($data_proyek['data_proyek_produk'])) $proyek->proyekProduks()->createMany($data_proyek['data_proyek_produk']);
                            }
                        });
                    }

                    $respData = [
                        'responreceiveNIB' => [
                            'status' => 1,
                            'keterangan' => 'Sukses menerima NIB'
                        ]
                    ];

                    Log::info('OSSAPI', [
                        'type' => 'receiveNIB',
                        'nib' => $nib,
                        'request' => $request->all(),
                        'response' => $respData
                    ]);
                } catch (\Exception $exception) {
                    DB::rollBack();
                    $message = $exception->getMessage();
                    $respData = [
                        'responreceiveNIB' => [
                            'status' => 2,
                            'keterangan' => $message
                        ]
                    ];
                    Log::error('OSSAPI', [
                        'type' => 'receiveNIB',
                        'nib' => $nib,
                        'request' => $request->all(),
                        'response' => $respData
                    ]);
                }
                return response()->json($respData);
            }
        }
        return response()->json([
            'responreceiveNIB' => [
                'status' => 2,
                'keterangan' => 'Unauthenticated!'
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receiveFileDS(Request $request)
    {
        if ($request->hasHeader('token')) {
            $token = $request->header('token');

            if ($token === $this->generateLocalToken($request->receiveFileDS['nib'])) {
                try {

                    $fileDS = $this->attachFileIzin(
                        $request->receiveFileDS['nib'],
                        $request->receiveFileDS['id_izin'],
                        $request->receiveFileDS['file_izin']
                    );
                    $respData = [
                        'responreceiveFileDS' => [
                            'status' => 1,
                            'keterangan' => 'Sukses ' . ($fileDS->wasChanged() ? 'mengupdate' : 'menerima') . ' file DS'
                        ]
                    ];
                    Log::info('OSSAPI', [
                        'type' => 'receiveFileDS',
                        'nib' => $request->receiveFileDS['nib'],
                        'request' => $request->all(),
                        'response' => $respData
                    ]);

                    return response()->json($respData);
                } catch (\Exception $exception) {
                    $message = $exception->getMessage();
                    if (NIB::where('nib', $request->receiveFileDS['nib'])->doesntExist()) {
                        $message = 'Pengajuan NIB ' . $request->receiveFileDS['nib'] . '  tidak terdaftar pada sistem ' . config('app.long_name');
                    }
                    if (Bujp::where('nib', $request->receiveFileDS['nib'])->doesntExist()) {
                        $message = 'NIB ' . $request->receiveFileDS['nib'] . '  tidak terdaftar pada sistem ' . config('app.long_name');
                    }

                    $respData = [
                        'responreceiveFileDS' => [
                            'status' => 2,
                            'keterangan' => $message
                        ]
                    ];

                    Log::error('OSSAPI', [
                        'type' => 'receiveFileDS',
                        'nib' => $request->receiveFileDS['nib'],
                        'request' => $request->all(),
                        'response' => $respData
                    ]);

                    return response()->json($respData);
                }
            }
        }

        return response()->json([
            'responreceiveNIB' => [
                'status' => 2,
                'keterangan' => 'Unauthenticated!'
            ]
        ]);
    }

    public function inqueryFileDS(string $id_izin)
    {
        $params = [
            'INQUERYFILEDS' => [
                "id_permohonan_izin" => $id_izin
            ]
        ];

        $headers = [
            'user_key' => config('oss-api.user_key'),
            'Content-Type' => 'application/json'
        ];

        DB::beginTransaction();
        try {
            $response = Http::withHeaders($headers)->withOptions(['verify' => false])->post((app()->environment('production') ? config('oss-api.prod_url') : config('oss-api.rba_url')) . 'inqueryFileDS', $params);

            if ($response->ok()) {
                $res = $response->json();

                Log::info('OSSAPI', [
                    'type' => 'inqueryFileDS',
                    'payloads' => $params,
                    'response' => $res
                ]);

                $respFileDS = $res['responInqueryFileDS'];

                if ($respFileDS['status'] == ResponseStatus::HTTP_BAD_REQUEST) {
                    //400: file ds not found, probably not yet printed TODO what should we handle this?

                }

                if ($respFileDS['status'] == ResponseStatus::HTTP_OK) {
                    //200: file ds available, update status to 6
                    $sio = RiwayatSio::query()->with('checklist.nib:id,nib')->where('id_izin', $id_izin)->first();
                    $this->attachFileIzin(
                        $sio->checklist->nib->nib,
                        $id_izin,
                        $respFileDS['url_file_ds']
                    );
                }
                DB::commit();
            }
        } catch (\Exception $exception){
            DB::rollBack();
            Log::error('OSSAPI', [
                'type'      => 'inqueryFileDS',
                'params'    => $params,
                'message'   => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param $nib
     * @return \Illuminate\Http\JsonResponse
     */
    public function inqueryNIB($nib)
    {
        $params = [
            'INQUERYNIB' => [
                "nib" => $nib
            ]
        ];


        $headers = [
            'user_key' => config('oss-api.user_key')
        ];

        $response = Http::withHeaders($headers)->withOptions(['verify' => false])
            ->post((app()->environment('production') ? config('oss-api.prod_url') : config('oss-api.rba_url')) . 'inqueryNIB', $params);

        if ($response->ok()) {
            $res = $response->json();

            Log::info('OSSAPI', [
                'type' => 'inqueryNIB',
                'nib' => $nib,
                'payloads' => $params,
                'response' => $res
            ]);

            $respDataNIB = $res['responinqueryNIB'];

            //kode singkronisasi data checklist, otomatis ketika inqueryNIB
            if (auth()->check() && auth()->user()->haveRoleID(User::BUJP)) {
                if (auth()->user()->bujp->nib !== $nib){
                    abort(403);
                }

                $dataNIB = collect($respDataNIB['dataNIB'])->except([
                    'pemegang_saham', 'penanggung_jwb', 'legalitas',
                    'data_rptka', 'data_proyek', 'data_dni', 'data_checklist'
                ])->toArray();
                DB::beginTransaction();
                try {
                    //sinkronisasi data NIB
                    $nibModel = NIB::updateOrCreate(['nib' => $nib], $dataNIB);
                    //sinkronisasi data pengajuan
                    $nibModel->proyeks()->delete();
                    $nibModel->checklists()->delete();

                    $checklists = collect(collect($respDataNIB['dataNIB']['data_checklist']))
                                    ->where('kd_izin', '060000000001')
                                    ->whereIn('id_bidang_spesifik', OSSConstant::ACCEPTED_ID_BIDANG);
                    $proyeks    = collect(collect($respDataNIB['dataNIB']['data_proyek']))
                                    ->whereIn('id_proyek', $checklists->where('id_proyek', '<>', '-')->pluck('id_proyek')->toArray());
                    //TODO tambahkan proyek_daerah_id untuk pengecekan kecamatan pmj
                    foreach ($checklists as $data_checklist) {
                        $proyek_daerah_id = $proyeks->where('id_proyek', $data_checklist['id_proyek'])->first()['data_lokasi_proyek'][0]['proyek_daerah_id'];
                        $riwayatSio = $this->createPengajuan($nibModel, $data_checklist, $this->getJenisPengajuan($proyek_daerah_id, $nibModel['perseroan_daerah_id']), $proyek_daerah_id);
                        if (isset($data_checklist['data_persyaratan'])) $riwayatSio->checklist->persyaratans()->createMany($data_checklist['data_persyaratan']);
                    }

                    foreach ($proyeks as $data_proyek) {
                        $proyek = $nibModel->proyeks()->create(collect($data_proyek)->except(['data_lokasi_proyek', 'data_lokasi_proyek'])->toArray());
                        if (isset($data_proyek['data_lokasi_proyek'])){
                            foreach (collect($data_proyek['data_lokasi_proyek'])->where('id_proyek_lokasi', '<>', '-') as $data_lokasi_proyek) {
                                $lokasiProyek = $proyek->lokasiProyeks()->create(collect($data_lokasi_proyek)->except(['data_posisi_proyek'])->toArray());
                                if (isset($data_lokasi_proyek['data_posisi_proyek'])) {
                                    $lokasiProyek->posisiProyeks()->createMany($data_lokasi_proyek['data_posisi_proyek']);
                                }
                            }
                        }
                        if (isset($data_proyek['data_proyek_produk'])) $proyek->proyekProduks()->createMany(array_filter($data_proyek['data_proyek_produk']));
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('OSSAPI', [
                        'type'      => 'sinkronisasiNIB',
                        'nib'       => $nib,
                        'checklist' => $checklists,
                        'proyek'    => $proyeks,
                        'message'   => $e->getMessage()
                    ]);
                }
            }

            return response()->json([
                'message'   => $respDataNIB['keterangan'],
                'code'      => $respDataNIB['kode'],
                'data'      => $respDataNIB['dataNIB'],
            ]);
        } else {
            return $this->responseErrorOSS($response->toException(), 'inqueryNIB', $params);
        }
    }

    public function receiveLicense($id_izin, $status = 50, $lampiran = "")
    {
        $checklist = Checklist::where('id_izin', $id_izin)->first();
        $params = [
            "IZINFINAL" => [
                "nib" => (string)$checklist->nib->nib,
                "id_produk" => (string)$checklist->id_produk,
                "id_proyek" => (string)$checklist->id_proyek,
                "oss_id" => (string)$checklist->nib->oss_id,
                "id_izin" => (string)$checklist->id_izin,
                "kd_izin" => (string)$checklist->kd_izin,
                "kd_daerah" => (string)$checklist->kd_daerah,
                "kewenangan" => (string)$checklist->kewenangan,
                "nomor_izin" => (string)$checklist->nomor_izin,
                "tgl_terbit_izin" => "",
                "tgl_berlaku_izin" => "",
                "nama_ttd" => "",
                "nip_ttd" => "",
                "jabatan_ttd" => "",
                "status_izin" => (string)$status,
                "file_izin" => "",
                "keterangan" => "",
                "file_lampiran" => $lampiran,
                "nomenklatur_nomor_izin" => "",
                "data_pnbp" => [
                    [
                        "kd_akun" => "",
                        "kd_penerimaan" => "",
                        "nominal" => ""
                    ]
                ]
            ]
        ];

        $headers = [
            'user_key' => config('oss-api.user_key')
        ];

        $response = Http::withHeaders($headers)->withOptions(['verify' => false])
            ->post((app()->environment('production') ? config('oss-api.prod_url') : config('oss-api.dev_url')) . 'receiveLicense', $params);

        if ($response->ok()) {
            $respData = $response->json()['responreceiveLicense'];
            Log::info('OSSAPI', [
                'type' => 'receiveLicense',
                'nib' => $checklist->nib->nib,
                'payloads' => $params,
                'response' => $respData
            ]);

            return response()->json([
                'code' => $respData['kode'],
                'message' => $respData['keterangan'],
                'nomor_izin' => $respData['nomor_izin'] ?? ""
            ]);
        } else {
            return $this->responseErrorOSS($response->toException(), 'receiveLicense', $params);
        }
    }

    public function receiveLicenseAttachment($id_izin, $status = 50)
    {
        $checklist = Checklist::where('id_izin', $id_izin)->first();
        $params = [
            "IZINFINAL" => [
                "nib" => (string)$checklist->nib->nib,
                "id_produk" => (string)$checklist->id_produk,
                "id_proyek" => (string)$checklist->id_proyek,
                "oss_id" => (string)$checklist->nib->oss_id,
                "id_izin" => (string)$checklist->id_izin,
                "kd_izin" => (string)$checklist->kd_izin,
                "kd_daerah" => (string)$checklist->kd_daerah,
                "kewenangan" => (string)$checklist->kewenangan,
                "nomor_izin" => (string)$checklist->nomor_izin,
                "tgl_terbit_izin" => "",
                "tgl_berlaku_izin" => "",
                "nama_ttd" => "",
                "nip_ttd" => "",
                "jabatan_ttd" => "",
                "status_izin" => (string)$status,
                "file_izin" => "",
                "keterangan" => "",
                "file_lampiran" => "",
                "nomenklatur_nomor_izin" => "",
                "data_pnbp" => [
                    [
                        "kd_akun" => "",
                        "kd_penerimaan" => "",
                        "nominal" => ""
                    ]
                ]
            ]
        ];

        $headers = [
            'user_key' => config('oss-api.user_key')
        ];

        $response = $this->sendRequest('receiveLicense', 'POST', $params);

        if ($response->ok()) {
            try {
                $respData = $response->json()['responreceiveLicense'];
                if (isset($respData['nomor_izin']) && !empty($nomorIzin = $respData['nomor_izin'])) {
                    $checklist->riwayatSio->update(['nomor_izin' => $nomorIzin]);
                    $generateLampiranSioAction = new GenerateLampiranSioAction();
                    $params['IZINFINAL']['file_lampiran'] = $generateLampiranSioAction->execute($checklist->riwayatSio);
                    $response = $this->sendRequest('receiveLicense', 'POST', $params);
                }

                $respData = $response->json()['responreceiveLicense'];
                Log::info('OSSAPI', [
                    'type' => 'receiveLicense',
                    'nib' => $checklist->nib->nib,
                    'payloads' => $params,
                    'response' => $respData
                ]);

                return response()->json([
                    'code' => $respData['kode'],
                    'message' => $respData['keterangan'],
                    'nomor_izin' => $respData['nomor_izin']
                ]);
            } catch (\Exception $exception){
                return response()->json([
                    'code'      => 500,
                    'message'   => $exception->getMessage()
                ]);
            }
        } else {
            return $this->responseErrorOSS($response->toException(), 'receiveLicense', $params);
        }
    }

    private function sendRequest($endpoint, $method = 'GET', array $params = [])
    {
        return Http::withHeaders([
                'user_key' => $endpoint === 'previewFile' ? config('oss-api.security_key') : config('oss-api.user_key')
            ])
            ->withOptions(['verify' => false])
            ->retry(3, 3000)
            ->post((app()->environment('production') ? config('oss-api.prod_url') : config('oss-api.dev_url')) . $endpoint, $params);
    }

    public function receiveLicenseStatus($id_izin, $message, $status = 20)
    {
        $checklist = Checklist::where('id_izin', $id_izin)->first();
        if ($checklist) {
            $params = [
                "IZINSTATUS" => [
                    "nib" => $checklist->nib->nib,
                    "id_produk" => (string)$checklist->id_produk,
                    "id_proyek" => (string)$checklist->id_proyek,
                    "oss_id" => (string)$checklist->nib->oss_id,
                    "id_izin" => (string)$checklist->id_izin,
                    "kd_izin" => (string)$checklist->kd_izin,
                    "kd_instansi" => "",
                    "kd_status" => (string)$status,
                    "tgl_status" => now()->toDateTimeString(),
                    "nip_status" => "",
                    "nama_status" => "",
                    "keterangan" => $message,
                    "data_pnbp" => [
                        [
                            "kd_akun" => "",
                            "kd_penerimaan" => "",
                            "nominal" => ""
                        ]
                    ]
                ]
            ];

            $headers = [
                'user_key' => config('oss-api.user_key')
            ];

            $response = Http::withHeaders($headers)->withOptions(['verify' => false])
                ->post((app()->environment('production') ? config('oss-api.prod_url') : config('oss-api.dev_url')) . 'receiveLicenseStatus', $params);

            if ($response->ok()) {
                $respData = $response->json()['responreceiveLicenseStatus'];

                Log::info('OSSAPI', [
                    'type' => 'receiveLicenseStatus',
                    'nib' => $checklist->nib->nib,
                    'payloads' => $params,
                    'response' => $respData
                ]);

                return response()->json([
                    'message' => $respData['keterangan'],
                    'code' => $respData['kode']
                ]);
            } else {
                return $this->responseErrorOSS($response->toException(), 'receiveLicenseStatus', $params);
            }
        }
    }

    public function previewFile($url)
    {
        $headers = [
            'user_key' => config('oss-api.security_key')
        ];

        $response = Http::withHeaders($headers)->withOptions(['verify' => false])
            ->get($url);

        if ($response->ok()) {
            return $response->body();
        } else {
            return $this->responseErrorOSS($response->toException(), 'previewFile');
        }
    }

    /**
     * @param $nib
     * @return string
     */
    private function generateLocalToken($nib): string
    {
        return sha1(config('oss-api.username') . config('oss-api.password') . $nib . date('Ymd'));
    }

    /**
     * Handle generate lampiran sio, return link pdf lampiran
     *
     * @param PendaftaranSio $pendaftaranSio
     */
    public function generateLampiranSio(PendaftaranSio $pendaftaranSio)
    {
        $this->fileName = 'lampiran-sio.pdf';
        $this->uploadPath = 'bujp';
        $this->folderName = $pendaftaranSio->bujp->nama_badan_usaha . '/' . 'sio' . '/';

        $fullPath = $this->uploadPath . '/' . $this->folderName . '/' . $this->fileName;
        $tempPath = 'temp/' . $pendaftaranSio->bujp_id . '/' . $this->fileName;

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.lampiran-sio', ['pendaftaranSio' => $pendaftaranSio]);
        Storage::put($tempPath, $pdf->output());

        $this->saveFiles(Storage::path($tempPath));
        return config('filesystems.storage_url') . $fullPath;
    }

    /**
     * @param $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseErrorOSS($exception, $method, array $payloads = [])
    {
        $message = $exception->getMessage();

        Log::error('OSSAPI', [
            'type' => $method,
            'nib' => $payloads[$method]['nib'] ?? "",
            'payloads' => $payloads,
            'message' => $message
        ]);

        $respData = [
            'respon' . $method => [
                'status' => 2,
                'keterangan' => $message
            ]
        ];

        return response()->json($respData);
    }

    private function createPengajuan(NIB $nib, $pengajuan, $type, $proyek_daerah_id)
    {
        $checklist = $nib->checklists()
            ->updateOrCreate(['id_izin' => $pengajuan['id_izin']], collect($pengajuan)->except(['data_persyaratan'])->toArray());
        $kode_provinsi = substr($proyek_daerah_id, 0, 2);
        $kode_kota = substr($proyek_daerah_id, 0, 4);
        $kode_kec = substr($proyek_daerah_id, 0, 6);
        $provinsi = Provinsi::where('code', $kode_provinsi)->select('polda')->first();
        $polda = $provinsi == null ? null : "POLDA $provinsi->polda";

        if (in_array($kode_kota, [
                '3671', //Kota Tangerang
                '3674', //Tangerang Selatan
                '3275', //Bekasi
                '3276', //Kota Depok
                '3216'  //Kabupaten Bekasi
            ]) || (in_array($kode_kec, [
                '320113', //Kec. Bojonggede - Kab. Bogor
                '320137', //Kec. Tajurhalang
                '360323', //Kec. Cisauk - Kab. Tangerang
                '360320', //Kec. Legok
                '360328', //Kec. Kelapa Dua
                '360317', //Kec. Curug
                '360322', //Kec. Pagedangan
                '360313', //Kec. Teluknaga
                '360315', //Kec. Pakuhaji
                '360316'  //Kec. Sepatan
            ]))){
            $polda = "POLDA METRO JAYA";
        }

        /**
         * Buat pengajuan sio baru
         */
        return $checklist->riwayatSio()->updateOrCreate(['id_izin' => $pengajuan['id_izin']], [
            'type' => $type,
            'polda' => $polda,
            'nomor_izin' => ($checklist->no_izin !== '-' ? $checklist->no_izin : null),
            'tanggal_pengajuan' => $checklist->riwayatSio->created_at ?? now()
        ]);
    }

    private function attachFileIzin($nib, $id_izin, $file_izin)
    {
        $fileDS = FileDS::updateOrCreate(['id_izin' => $id_izin], [
            'nib' => $nib,
            'file_izin' => $file_izin
        ]);

        NIB::where('nib', $nib)->first()
            ->checklists()->where('id_izin', $id_izin)
            ->update(['file_izin' => $file_izin]);

        if ($riwayatSio = RiwayatSio::where('id_izin', $id_izin)
            ->whereNotNull('nomor_izin')->first()) {
            $riwayatSio->statusSios()->attach([6 => ['keterangan' => 'SIO telah terbit pada ' . now()]]);
        }
        return $fileDS;
    }

    private function getJenisPengajuan($proyek_daerah_id, $perseroan_daerah_id)
    {
        return $this->getCitiesCode($proyek_daerah_id) === $this->getCitiesCode($perseroan_daerah_id) ? RiwayatSio::KANTOR_PUSAT : RiwayatSio::PERLUASAN;
    }

    private function getCitiesCode($kode_daerah)
    {
        return substr($kode_daerah, 0, 4);
    }
}
