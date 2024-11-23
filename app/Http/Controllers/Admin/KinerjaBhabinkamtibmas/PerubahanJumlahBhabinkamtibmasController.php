<?php

namespace App\Http\Controllers\Admin\KinerjaBhabinkamtibmas;

use App\Exports\PerubahanJumlahBhabinkamtibmasExport;
use App\Helpers\ApiHelper;
use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\Imports\Sislap\ReadRows;
use App\Models\DataPerubahanJumlahBhabinkamtibmas;
use App\Models\LokasiPenugasan;
use App\Models\Personel;
use App\Models\Provinsi;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PerubahanJumlahBhabinkamtibmasController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function getDatatable(Request $request, $polda = '')
    {
        $query = DataPerubahanJumlahBhabinkamtibmas::latest()
            ->with("lokasi_tugas", "personel")
            ->when($polda !== '', function($q) use ($polda) {
                $q->where('polda', 'ilike', '%' . $polda . '%');
            })
            ->when(auth()->user()->haveRoleID(User::OPERATOR_BHABINKAMTIBMAS_POLDA), function($q) {
                $q->where("polda", auth()->user()->personel->polda);
            })
            ->when(auth()->user()->haveRoleID(User::OPERATOR_BHABINKAMTIBMAS_POLRES), function($q) {
                $q->where("polres", auth()->user()->personel->polres);
            })
            ->when(auth()->user()->haveRoleID(User::OPERATOR_BHABINKAMTIBMAS_POLSEK), function($q) {
                $q->where("polsek", auth()->user()->personel->polsek);
            });

        return DataTables::eloquent($query)
            ->addColumn('file_data_personel_bhabinkamtibmas_polres', function($q) {
                return '<a href="'. $q->file_data_personel_bhabinkamtibmas_polres .'" target="_blank">lampiran file</a>';
            })
            ->addColumn('jumlah_bhabinkamtibmas', function($q) {
                $element = '<div class="d-flex align-items-center justify-content-center">';
                $element .= '<span class="d-block mr-2">'. $q->jumlah_bhabinkamtibmas .'</span>';
                $element .= '<button class="btn-sm btn-info btn-anggota-bhabin" data-link_file_data_personel="'. $q->file_data_personel_bhabinkamtibmas_polres .'"><i class="fa fa-info"></i></button>';
                $element .= '</div>';

                return $element;
            })
            ->addColumn('action', function($q) {
                $action = '<div class="d-flex justify-content-center">';
                $action .= '
                    <button href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#editDataPerubahanJumlahBhabin" data-id="'.$q->id.'" onclick="inserValueToFormEdit({id:'. $q->id .',no_skep:\''. $q->no_skep .'\',jumlah_bhabinkamtibmas:'.$q->jumlah_bhabinkamtibmas.'})">
                        <i class="fas fa-edit"></i>
                    </button>
                ';
                $action .= '
                    <form class="ml-2" id="delete_data_perubahan_bhabin_'. $q->id .'" action="'. route('perubahan-jumlah-bhabinkamtibmas.delete', $q->id) .'" method="post">
                        <input type="hidden" name="_token" value="'. csrf_token() .'">
                        <input type="hidden" name="_method" value="delete">
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete-data-bhabin" data-id="'.$q->id.'" onclick="
                                            confirm(\'Apakah anda yakin akan menghapus data ini?\')
                                                ? document.querySelector(\'#delete_data_perubahan_bhabin_'. $q->id .'\').submit()
                            : \'\'">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                ';
                $action .= '</div>';

                return $action;
            })
        ->rawColumns(["action", 'file_data_personel_bhabinkamtibmas_polres', 'jumlah_bhabinkamtibmas'])
        ->toJson();
    }

    public function getDatatableAnggotaBhabin(Request $request)
    {
        $linkFile = $request->link_file;

        // download file from cloud
        $client = new Client();
        $response = $client->get($linkFile);

        // get extension of file
        $extension = pathinfo(parse_url($linkFile, PHP_URL_PATH), PATHINFO_EXTENSION);

        // save excel file to temp storage
        $tempPath = tempnam(sys_get_temp_dir(), 'excel_') . '.' . $extension;
        file_put_contents($tempPath, $response->getBody());

        // from excel data, changes to array data so that can be read by php
        $dataExcel = Excel::toArray(new ReadRows(), $tempPath);
        unlink($tempPath);

        // unset all useless data (header)
//        for($i = 0; $i<=7;$i++) {
            unset($dataExcel[0][0]);
//        }

        return response()->json($dataExcel[0]);
    }

    public function searchPersonel(Request $request)
    {
        $request->validate([
            'nrp' => 'required|digits:8'
        ]);
        $arrayPersonel = ApiHelper::getBhabinByNrp($request->nrp);
        if (!is_array($arrayPersonel)){
            return $arrayPersonel;
        }

        $personel = Personel::find($arrayPersonel['personel_id']);
        $result = array_merge($arrayPersonel, ['role_id' => $personel ? $personel->user->getRole()->id : ""]);

        $lokasiTugas = LokasiPenugasan::latest()->firstWhere('user_id', $personel->user_id)->only("lokasi");
        $result["lokasi_tugas"] = $lokasiTugas;

        return response($result);
    }

    public function updateBhabinkamtibmasPolda(Request $request, $polda = '')
    {
        if(auth()->user()->lokasi_tugas) {
            $provinceCode = auth()->user()->lokasi_tugas?->province_code;
            $prov = Provinsi::firstWhere('code', $provinceCode);
        } else {
            $prov = Provinsi::where('polda', 'ilike', '%' . str_replace('POLDA ', '', $polda ?? auth()->user()->personel->polda) . '%')->first();
        }

        // if prov is null or empty
        if(!$prov || empty($prov) || !$prov->jumlah_bhabin) {
            $this->flashWarning("Daerah Provinsi bhabinkamtibmas yang ingin diupdate tidak valid! <br>Mohon bisa kontak administator untuk mengupdate jumlah bhabinkamtibmas");
            return redirect()->back();
        }

        if($prov->jumlah_bhabin == $request["jumlah_bhabin"]) {
            $this->flashWarning("Jumlah Bhabinkamtibmas tidak berubah");
            return redirect()->back();
        }

        if($request["jumlah_bhabin"] < 0 || $request["jumlah_bhabin"] === 'null') {
            $this->flashWarning("Anda belum memasukkan data bhabin! Pastikan jumlah bhabin tidak kosong");
            return redirect()->back();
        }

        $prov->update([
            'jumlah_bhabin' => $request["jumlah_bhabin"]
        ]);

        $this->flashSuccess("Berhasil mengubah jumlah Bhabinkamtibmas " . auth()->user()->personel->polda);
        return redirect()->back();
    }

    public function perubahanJumlahBhabin()
    {
        return view('administrator.kinerja-bhabinkamtibmas.edit-jumlah-bhabin');
    }

    public function adminPerubahanJumlahBhabin($polda)
    {
        if(!role('administrator')) {
            abort(403);
            return;
        }

        if(Personel::where('satuan1', 'ilike', '%' . $polda . '%')->count() === 0) {
            abort(404);
            return;
        }

        return view('administrator.kinerja-bhabinkamtibmas.edit-jumlah-bhabin', compact('polda'));
    }

    public function storeDataBhabin(Request $request)
    {
        $data = $request->validate([
            "nrp" => "required|string|max:20",
            "no_skep" => "required|string|max:50"
        ]);

        try {
            DB::beginTransaction();
            User::firstWhere("nrp", $data['nrp'])->personel()->update([
                "no_skep" => $data["no_skep"]
            ]);

            unset($data['no_skep']);

//            if(auth()->user()->personel->polda !== 'POLDA METRO JAYA') {
//                $data['province_code'] = auth()->user()->lokasi_tugas->province_code;
//            } else {
//                $data['province_code'] = Constants::idMetroJaya;
//            }
            $data['province_code'] = auth()->user()->lokasi_tugas->province_code;
            $data['city_code'] = auth()->user()->lokasi_tugas->city_code;
            $data['district_code'] = auth()->user()->lokasi_tugas->district_code;

            DataPerubahanJumlahBhabinkamtibmas::create($data);
            DB::commit();

            return $this->responseSuccess([
                "message" => "Berhasil menambahkan data Bhabinkamtibmas"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseError($e);
        }
    }

    public function getListPolres($polda = '')
    {
        $kode_satuan = $polda != '' ? Personel::firstWhere('satuan1', 'ilike', '%' . $polda . '%')->kode_satuan : auth()->user()->personel->kode_satuan;
        $polres_list = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        foreach($polres_list as $polres)
        {
            $result[] = [
                'id' => $polres['nama_satuan'],
                'text' => $polres['nama_satuan'],
            ];
        }
        return $result;
    }

    public function store(Request $request, $polda = '')
    {
        $data = $request->validate([
            'polres' => 'required|string|max:75',
            'file_data_personel_bhabinkamtibmas_polres' => 'required|file|max:12400',
            'jumlah_bhabinkamtibmas' => 'required|numeric',
        ]);

        if($polda !== '') {
            $polda = 'Polda ' . $polda;
        }

        try {
            DB::beginTransaction();
//            $polda_province_code = Provinsi::firstWhere('polda', 'ilike', '%' . str_replace('POLDA ', '', auth()->user()->personel->polda) . '%')->code;

            $polda = $polda ?? auth()->user()?->personel?->polda;
            $polres = auth()->user()?->personel?->polres;

            $dataExcel = Excel::toArray(new ReadRows(), $request->file('file_data_personel_bhabinkamtibmas_polres'));


            // unset all useless data
//            for($i = 0; $i<=7;$i++) {
                unset($dataExcel[0][0]);
//            }

            $totalBhabin = count($dataExcel[0]);
            $totalNrpUnique = count(array_unique(array_map(fn($item) => $item[3], $dataExcel[0])));

            if($totalBhabin !== $totalNrpUnique) {
                $this->flashWarning('Terdapat NRP yang sama! Mohon untuk tidak menginputkan data bhabinkamtibmas dengan NRP yang sama');
                return redirect()->back();
            }

            if($totalBhabin !== (int)$data['jumlah_bhabinkamtibmas']) {
                $this->flashWarning('Data jumlah bhabinkamtibmas tidak cocok dengan total bhabinkamtibmas pada lampiran file data Personel');
                return redirect()->back();
            }

            $bhabinDidaftarkan = 0;
            $nrpNewBhabin = [];

            foreach($dataExcel[0] as $singleExcel) {
                $nrp = $singleExcel[3];

                $polres = str_contains(strtoupper($singleExcel[4]), 'POLRES')
                    ? strtoupper($singleExcel[4])
                    : "POLRES " . strtoupper($singleExcel[4]);
                $no_skep = $singleExcel[9];

                if(strlen($nrp) !== 8) {
                    $this->flashWarning('Terdapat data NRP yang tidak valid! (Kosong atau tidak sesuai format)<br>Berikut adalah NRP-nya: ' . $nrp);
                    return redirect()->back();
                }
                if(strlen($polres) === 0 || strlen($no_skep) === 0) {
                    $this->flashWarning('Harap lengkapi data penting seperti Polres dan No SKEP<br>Mohon agar data tersebut tidak kosong!');
                    return redirect()->back();
                }

                if($polres !== $data['polres']) {
                    $this->flashWarning('Salah satu data Personel Bhabinkamtibmas memiliki polres yang tidak sama dengan yang diinputkan');
                    return redirect()->back();
                }

                if(User::where('nrp', $nrp)->count()) {
                    User::firstWhere('nrp', $nrp)?->personel()?->update([
                        'no_skep' => $no_skep
                    ]);
                } else {
                    $user = $this->userService->store([
                        'nrp' => $nrp,
                        'email' => $nrp . '@polri.go.id',
                        'password' => bcrypt($nrp),
                    ], [User::BHABIN]);

                    $this->createPersonelData($user);

                    $user->personel()->update([
                        'no_skep' => $no_skep
                    ]);

                    // count registered new bhabin
                    $bhabinDidaftarkan += 1;
                    $nrpNewBhabin[] = $nrp;
                }
            }


            $this->fileName = random_int(100000, 999999) . '_' . $request->file('file_data_personel_bhabinkamtibmas_polres')->getClientOriginalName();
            $this->uploadPath = 'file_data_personel_bhabinkamtibmas_polres';
            $this->folderName = 'perubahan_jumlah_bhabin';

            $data['polda'] = $polda;
            $data['polres'] = $polres;
            $data["file_data_personel_bhabinkamtibmas_polres"] = $this->saveFiles($request->file_data_personel_bhabinkamtibmas_polres);
            DataPerubahanJumlahBhabinkamtibmas::create($data);

//            if(auth()->user()->haveRoleID(User::OPERATOR_BHABINKAMTIBMAS_POLDA)) {
//                Provinsi::where('code', $polda_province_code)->update([
//                    'jumlah_bhabin' => $data['jumlah_bhabinkamtibmas']
//                ]);
//            }

            DB::commit();
            $this->flashSuccess('Berhasil menyimpan data bhabinkamtibmas terbaru – ' . $polres
                . ($bhabinDidaftarkan > 0 ? '<br>Dengan total bhabin terbaru yang didaftarkan sebanyak ' . $bhabinDidaftarkan
                . '<br>Berikut NRP-nya: ' . implode(', ', $nrpNewBhabin) : '<br>Tidak ada bhabinkamtibmas baru yang didaftarkan')
            );
        } catch (\Exception $e) {
            DB::rollBack();
            $this->flashError($e->getMessage());
        }

        return redirect()->back();
    }

    public function updateDataBhabin(Request $request, $id)
    {
        $dataBhabin = DataPerubahanJumlahBhabinkamtibmas::find($id);

        $data = $request->validate([
            "nrp" => "required|string|max:20",
            "nama" => "required|string|max:50",
            "no_skep" => "required|string|max:50"
        ]);

        $dataBhabin->update($data);

        $this->flashSuccess("Berhasil mengubah data Bhabinkamtibmas");
        return redirect()->route('perubahan-jumlah-bhabinkamtibmas.index');
    }

    public function update(Request $request, $id, $polda = '')
    {
        $data = $request->validate([
//            'no_skep' => 'required|string|max:50',
            'file_skep' => 'nullable|file|max:2048',
            'jumlah_bhabinkamtibmas' => 'required|numeric',
            'lampiran_nrp' => 'nullable|file'
        ]);

        $perubahanJumlahBhabin = DataPerubahanJumlahBhabinkamtibmas::find($id);

        // jika ada perubahan jumlah bhabin tapi tidak melampirkan nrp bhabin terbaru
        if($data["jumlah_bhabinkamtibmas"] != $perubahanJumlahBhabin->jumlah_bhabinkamtibmas && !isset($data["lampiran_nrp"])) {
            $e = new \Exception('Silahkan upload Lampiran NRP jika anda melakukan perubahan jumlah bhabinkamtibmas!');
            return $this->responseError($e);
        }

        try {
            DB::beginTransaction();
            $polda_province_code = Provinsi::firstWhere('polda', 'ilike', '%' . str_replace('POLDA ', '', $polda ?? auth()->user()->personel->polda) . '%')->code;

            if($request->file('lampiran_nrp')) {
                $list_nrp = Excel::toArray(new ReadRows(), $request->file('lampiran_nrp'));
                unset($list_nrp[0][0]); // unset/menghilangkan header excel

                $chunkSize = 2500;
                collect($list_nrp)->chunk($chunkSize)->each(function($nrpChunk) use ($data) {
                    foreach($nrpChunk as $nrp) {
                        $arr_nrp = array_map(fn($item) => $item[0], $nrp);

                        Personel::whereHas('user', function($q) use ($arr_nrp) {
                            $q->whereIn('nrp', $arr_nrp);
                        })->update([
                            'no_skep' => $data['no_skep']
                        ]);
                    }
                });

                unset($data["lampiran_nrp"]);
            }

            if($request->file('file_skep')) {
                $this->fileName = random_int(100000, 999999) . '_' . $request->file('file_skep')->getClientOriginalName();
                $this->uploadPath = 'file_skep';
                $this->folderName = 'perubahan_jumlah_bhabin';
                $data["file_skep"] = $this->saveFiles($request->file('file_skep'));
            }

            // jika ada perubahan data nomor skep
            if($data['no_skep'] != $perubahanJumlahBhabin->no_skep) {
                Personel::where('no_skep', $perubahanJumlahBhabin->no_skep)->update([
                    'no_skep' => $data['no_skep']
                ]);
            }

            // jumlah bhabin akan otomatis di update ketika user merupakan operator bhabin polda
            if(auth()->user()->haveRoleID(User::OPERATOR_BHABINKAMTIBMAS_POLDA) && $data["jumlah_bhabinkamtibmas"] != $perubahanJumlahBhabin->jumlah_bhabinkamtibmas) {
                Provinsi::where('code', $polda_province_code)->update([
                    'jumlah_bhabin' => $data['jumlah_bhabinkamtibmas']
                ]);
            }

            $perubahanJumlahBhabin->update($data);

            DB::commit();
            return $this->responseSuccess([
                "message" => 'Berhasil melakukan update data'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseError($e);
        }
    }

    public function templateExcel()
    {
        return Excel::download(new PerubahanJumlahBhabinkamtibmasExport(), 'template-lampiran-nrp-bhabinkamtibmas.xlsx');
    }

    public function deleteDataBhabin(Request $request, $id)
    {
        $dataBhabin = DataPerubahanJumlahBhabinkamtibmas::find($id);

        Personel::where('no_skep', $dataBhabin?->no_skep)?->update([
            'no_skep' => null
        ]);

        $dataBhabin->delete();

        $this->flashSuccess("Berhasil menghapus data Bhabinkamtibmas yang dipilih");
        return redirect()->route('perubahan-jumlah-bhabinkamtibmas.index');
    }

    public function calculateTotalBhabinPolda($polda = '')
    {
        $polda = $polda ?? auth()->user()->personel->polda;

        $kode_satuan = $polda ? Personel::firstWhere('satuan1', 'ilike', '%' . $polda . '%')->kode_satuan : auth()->user()->personel->kode_satuan;
        $polresListTemp = \App\Helpers\ApiHelper::getChildSatuanByKodeSatuan(substr($kode_satuan, 0, 3), true);
        $polresList = [];

        foreach($polresListTemp as $polres) {
            $polresList[$polres['nama_satuan']] = 'belum upload data jumlah bhabinkamtibmas';
        }

        $latestEntries = DataPerubahanJumlahBhabinkamtibmas::select('polres', DB::raw('MAX(id) as id'))
            ->where('polda', $polda)
            ->groupBy('polres');

        $dataJumlahBhabin = DataPerubahanJumlahBhabinkamtibmas::joinSub($latestEntries, 'latest_entries', function ($join) {
            $join->on('data_perubahan_jumlah_bhabinkamtibmas.id', '=', 'latest_entries.id');
        })->get();

        $totalBhabin = $dataJumlahBhabin->reduce(function(?int $carry, $item) {
            return $carry + $item->jumlah_bhabinkamtibmas;
        });

        foreach($dataJumlahBhabin->toArray() as $perubahanJumlahBhabin) {
            $polresList[$perubahanJumlahBhabin["polres"]] = $perubahanJumlahBhabin["jumlah_bhabinkamtibmas"];
        }

        return response()->json([
            'data_bhabin' => $polresList,
            'total_bhabin' => $totalBhabin
        ]);
    }

    private function createPersonelData(User $user)
    {
        $personelModel = '';

        $personel = ApiHelper::getPersonelSingkatByNrp($user->nrp);
        if (!empty($personel)) {
            Personel::updateOrCreate([
                'personel_id' => $personel['personel_id'],
            ], [
                'user_id' => $user->id,
                'nama' => $personel['nama'],
                'pangkat' => $personel['pangkat'],
                'jabatan' => $personel['jabatan'],
                'keterangan_tambahan' => $personel['keterangan_tambahan'],
                'tmt_jabatan' => $personel['tmt_jabatan'],
                'lama_jabatan' => $personel['lama_jabatan'],
                'satuan' => $personel['satuan'],
                'jenis_kelamin' => $personel['jenis_kelamin'],
                'tanggal_lahir' => $personel['tanggal_lahir'],
                'email' => $personel['email'],
                'satuan1' => $personel['satuan1'],
                'satuan2' => $personel['satuan2'],
                'satuan3' => $personel['satuan3'],
                'satuan4' => $personel['satuan4'],
                'satuan5' => $personel['satuan5'],
                'satuan6' => $personel['satuan6'],
                'satuan7' => $personel['satuan7'],
            ]);

            if (empty($user->personel->handphone)) {
                $user->personel->handphone = $personel['handphone'];
                $user->personel->save();
            }
        }
    }
}
