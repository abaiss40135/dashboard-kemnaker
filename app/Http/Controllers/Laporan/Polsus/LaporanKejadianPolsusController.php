<?php

namespace App\Http\Controllers\Laporan\Polsus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Polsus\Laporan\LaporanKejadianPolsusRequest;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\LaporanKejadianPolsus;
use App\Models\PelakuLaporanKejadianPolsus;
use App\Models\Provinsi;
use App\Models\SaksiLaporanKejadianPolsus;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaporanKejadianPolsusController extends Controller
{
    private $provinsi;

    public function __construct()
    {
        $this->provinsi = Provinsi::orderBy('code', 'ASC')->pluck('name', 'code');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;

        if ($request->ajax()) {
            if (!isset($user_id)) {
                return response()->json(['error' => 'Polsus not found']);
            }

            return (new DataTables)->eloquent(LaporanKejadianPolsus::where('user_id', $user_id))
                    ->addColumn('jumlah_saksi', function ($data) {
                        $type = [0];
                        $idArray = $data->saksi()->pluck('id')->toArray();
                        $dataGabungan = array_merge($type, $idArray);
                        $stringIdArray = implode(",", $dataGabungan);
                        return $data->saksi()->count() . ' <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="setDetailModalContent(' . $stringIdArray . ')"> <i data-toggle="tooltip" data-placement="bottom" title="Detail Saksi" class="fa fa-info-circle"></i> </button>';
                    })
                    ->addColumn('jumlah_pelaku', function ($data) {
                        $type = [1];
                        $idArray = $data->pelaku()->pluck('id')->toArray();
                        $dataGabungan = array_merge($type, $idArray);
                        $stringIdArray = implode(",", $dataGabungan);
                        return $data->pelaku()->count() . ' <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"  data-bs-target="#detailModal" onclick="setDetailModalContent(' . $stringIdArray . ')"> <i  class="fa fa-info-circle"></i> </button>';
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('polsus.laporan-kejadian-polsus.edit', $data->id).'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>' .
                               '<a data-id="'. $data->id .'" class="btn-delete btn btn-sm btn-danger mt-2"><i class="fa fa-trash"></i></a>'
                            ;
                    })
                    ->rawColumns(['action', "jumlah_saksi", "jumlah_pelaku"])
                    ->make(true);
        }


        return view('polsus.laporan.laporan-kejadian-polsus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('polsus.laporan.laporan-kejadian-polsus.create', [
            'provinsi' => $this->provinsi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LaporanKejadianPolsusRequest $request)
    {
        $data = $request->validated();

        $this->uploadPath = 'laporan/polsus';
        $this->folderName = 'bukti-laporan';
        $this->fileName = now() . '.' . $request->file('barang_bukti')->getClientOriginalExtension();

        $path = $this->uploadPath . '/' . $this->folderName . '/' . $this->fileName;
        $this->saveFiles($request->file('barang_bukti'));

        $data["barang_bukti"] = $path;
        $laporan = auth()->user()->laporanKejadianPolsus()->create(collect($data)->except("saksi", "pelaku")->toArray());

        foreach($data["saksi"] as $saksi) {
            $laporan->saksi()->create([
                "nama"      => $saksi['nama_saksi'],
                "alamat"    => $saksi["alamat_saksi"],
                "pekerjaan" => $saksi["pekerjaan_saksi"]
            ]);
        }

        foreach($data["pelaku"] as $pelaku) {
            $laporan->pelaku()->create([
                "nama"      => $pelaku['nama_pelaku'],
                "usia"      => $pelaku["usia_pelaku"],
                "alamat"    => $pelaku["alamat_pelaku"],
                "pekerjaan" => $pelaku["pekerjaan_pelaku"]
            ]);
        }

        $this->flashSuccess('Berhasil menambahkan data' );
        return redirect()->route('polsus.laporan-kejadian-polsus.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $data = LaporanKejadianPolsus::find($id);
        return view('polsus.laporan.laporan-kejadian-polsus.edit', [
            "edit"              => true,
            'data'              => $data,
            "action"            => route("polsus.laporan-kejadian-polsus.update", $id),
            "method"            => "patch",
            'provinsi'          => $this->provinsi,
            "kabupaten"         => Kota::where("province_code", Provinsi::firstWhere("name", $data->provinsi)->code)->get(["name", "code"]),
            "kecamatan"         => Kota::firstWhere("name", $data->kabupaten)->kecamatans,
            "desa"              => Kecamatan::firstWhere("name", $data->kecamatan)->desas,
            "provinsi_laporan"  => $data->provinsi,
            "kabupaten_laporan" => $data->kabupaten,
            "kecamatan_laporan" => $data->kecamatan,
            "desa_laporan"      => $data->desa
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LaporanKejadianPolsusRequest $request, $id)
    {
        $laporan = LaporanKejadianPolsus::find($id);
        abort_if(auth()->user()->id !== $laporan->user_id, 403, "Anda tidak memiliki akses untuk halaman ini!");

        $data = $request->validated();

        if($request->barang_bukti) {
            $this->deleteFiles($laporan->barang_bukti);

            $this->uploadPath = 'laporan/polsus';
            $this->folderName = 'bukti-laporan';
            $this->fileName = now() . '.' . $request->file('barang_bukti')->getClientOriginalExtension();

            $path = $this->uploadPath . '/' . $this->folderName . '/' . $this->fileName;
            $this->saveFiles($request->file('barang_bukti'));

            $data["barang_bukti"] = $path;
        }


        $dataSemuaPelaku = [];
        foreach($data["pelaku"] as $pelaku) {
            $jenisData = $pelaku["idpelaku"] ?? "";
            if($jenisData) {
                $dataSemuaPelaku[$pelaku["idpelaku"]] = [
                    "laporan_id" => $laporan->id,
                    "nama" => $pelaku["nama_pelaku"],
                    "usia" => $pelaku["usia_pelaku"],
                    "alamat" => $pelaku["alamat_pelaku"],
                    "pekerjaan" => $pelaku["pekerjaan_pelaku"]
                ];
            } else {
                $dataSemuaPelaku[] = [
                    "laporan_id" => $laporan->id,
                    "nama" => $pelaku["nama_pelaku"],
                    "usia" => $pelaku["usia_pelaku"],
                    "alamat" => $pelaku["alamat_pelaku"],
                    "pekerjaan" => $pelaku["pekerjaan_pelaku"]
                ];
            }
        }
        foreach($laporan->pelaku as $pelakuKejadian) {
            $idPelaku = array_keys($dataSemuaPelaku);

            if(array_search($pelakuKejadian->id, $idPelaku) === false) {
                $pelakuKejadian->delete();
            }

            $pelaku = $dataSemuaPelaku[$pelakuKejadian->id] ?? "";
            if($pelaku) {
                $pelakuKejadian->update($pelaku);
                unset($dataSemuaPelaku[$pelakuKejadian->id]);
            }
        }
        $laporan->pelaku()->insert($dataSemuaPelaku);

        $dataSemuaSaksi = [];
        foreach($data["saksi"] as $saksi) {
            $jenisData = $saksi["idsaksi"] ?? "";
            if($jenisData) {
                $dataSemuaSaksi[$saksi["idsaksi"]] = [
                    "laporan_id" => $laporan->id,
                    "nama" => $saksi["nama_saksi"],
                    "alamat" => $saksi["alamat_saksi"],
                    "pekerjaan" => $saksi["pekerjaan_saksi"]
                ];
            } else {
                $dataSemuaSaksi[] = [
                    "laporan_id" => $laporan->id,
                    "nama" => $saksi["nama_saksi"],
                    "alamat" => $saksi["alamat_saksi"],
                    "pekerjaan" => $saksi["pekerjaan_saksi"]
                ];
            }
        }
        foreach($laporan->saksi as $saksiLaporan) {
            $idSaksi = array_keys($dataSemuaSaksi);


            if(array_search($saksiLaporan->id, $idSaksi) === false) {
                $saksiLaporan->delete();
            }

            $saksi = $dataSemuaSaksi[$saksiLaporan->id] ?? "";
            if($saksi) {
                $saksiLaporan->update($saksi);
                unset($dataSemuaSaksi[$saksiLaporan->id]);
            }
        }
        $laporan->saksi()->insert($dataSemuaSaksi);


        $laporan = $laporan->update($request->except('saksi', 'pelaku'));

        $this->flashSuccess('Berhasil Mengupdate Laporan');
        return redirect()->route('polsus.laporan-kejadian-polsus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        try {
            $laporan = LaporanKejadianPolsus::find($id);

            $this->deleteFiles($laporan->barang_bukti);

            $laporan->saksi()->delete();
            $laporan->pelaku()->delete();
            $laporan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Data'
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Menghapus Data'
            ]);
        }
    }

    public function getPelaku(Request $request)
    {
        $pelaku = PelakuLaporanKejadianPolsus::query()->find($request->data);

        return response()->json([
            "pelaku" => $pelaku,
        ]);
    }

    public function getSaksi(Request $request)
    {
        $saksi = SaksiLaporanKejadianPolsus::query()->find($request->data);

        return response()->json([
            "saksi" => $saksi,
        ]);
    }
}


//$idPelaku = array_map(function($pelaku) {
//    return $pelaku["idpelaku"] ?? "";
//}, $data["pelaku"]);
//
//foreach($data["pelaku"] as $pelaku) {
//    if($laporan->pelaku()->count() >= 1)
//    {
//        foreach($laporan->pelaku as $pelakuKejadian) {
//            if(array_search($pelakuKejadian->id, $idPelaku) === false) {
//                $pelakuKejadian->delete();
//            } else {
//                $pelakuKejadian->update($pelaku);
//            }
//        }
//    }
//    else
//    {
//        PelakuLaporanKejadianPolsus::create([
//            "nama" => $pelaku["nama_pelaku"],
//            "usia" => $pelaku["usia_pelaku"],
//            "pekerjaan" => $pelaku["pekerjaan_pelaku"],
//            "alamat" => $pelaku["alamat_pelaku"]
//        ]);
//    }
//}
