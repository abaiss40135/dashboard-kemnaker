<?php

namespace App\Http\Controllers\Laporan\Satpam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Satpam\Laporan\LaporanKegiatanRequest;
use App\Models\LaporanKejadianSatpam;
use App\Models\Provinsi;
use App\Models\SaksiLaporanSatpam;
use App\Models\Satpam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaporanKejadianController extends Controller
{
    private $provinsi;

    public function __construct()
    {
        $this->provinsi = Provinsi::pluck('name', 'code');
    }

    private function addBukti($file){
        $this->uploadPath = auth()->user()->nrp . '/laporan/both/video/' .
                            Carbon::now()->isoFormat('Y-m-d');
        return $this->saveFiles($file);
    }

    private function deleteBukti($id){
        $url = LaporanKejadianSatpam::where('id', $id)->pluck('bukti');
        if(!empty($url)) {
            $this->deleteFiles($url);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $satpam_id = auth()->user()->satpam ? auth()->user()->satpam->id : null;

        if ($request->ajax()) {
            if (!isset($satpam_id)) {
                return response()->json(['error' => 'Satpam not found']);
            }

            return (new DataTables)->eloquent(LaporanKejadianSatpam::where('satpam_id', $satpam_id))
                    ->addColumn('bukti', function($data){
                        return '<a href="'.$data->url_bukti.'" target="_blank">'.$data->bukti.'</a>';
                    })
                    ->addColumn('waktu', function ($data) {
                        return $data->hari_kejadian.', '.$data->tanggal_kejadian;
                    })
                    ->addColumn('lokasi', function ($data) {
                        return ucwords(strtolower($data->provinsi.', '.$data->kabupaten.', '.$data->kecamatan.', '.$data->desa));
                    })
                    ->addColumn('pelaku', function ($data) {
                        return $data->nama_pelaku.' ('.$data->jenis_kelamin_pelaku .
                               ' '.$data->pekerjaan_pelaku.')';
                    })
                    ->addColumn('korban', function ($data) {
                        return $data->nama_korban.' ('.$data->jenis_kelamin_korban .
                               ' '.$data->pekerjaan_korban.')';
                    })
                    ->addColumn('action', function ($data) {
                        return '<a href="'.route('satpam.laporan-kejadian.edit', $data->id).'" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>' .
                               '<a data-id="'. $data->id .'" class="btn-delete btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        // $data = LaporanKejadianSatpam::where('satpam_id', $satpam_id)
        //         ->latest()->paginate(10);
        return view('satpam.laporan.laporan-kejadian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('satpam.laporan.laporan-kejadian.create', [
            'provinsi' => $this->provinsi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LaporanKegiatanRequest $request)
    {
        $satpam_id = auth()->user()->satpam ? auth()->user()->satpam->id : null;
        $advanced = [
            'satpam_id' =>  $satpam_id,
            'bukti' => $this->addBukti($request->bukti),
        ];

        $data = array_merge($request->all(), $advanced);
        $laporan = LaporanKejadianSatpam::create($data);

        if($request->saksi) {
            foreach($request->saksi as $saksi) {
                $saksi['laporan_kejadian_id'] = $laporan->id;
                SaksiLaporanSatpam::create($saksi);
            }
        }

        $this->flashSuccess('Berhasil menambahkan data' );
        return redirect()->route('satpam.laporan-kejadian.index');
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = LaporanKejadianSatpam::where('id', $id)->first();
        $saksi = SaksiLaporanSatpam::where('laporan_kejadian_id', $id)->get();

        return view('satpam.laporan.laporan-kejadian.edit', [
            'data'     => $data,
            'provinsi' => $this->provinsi,
            'saksi'    => $saksi
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LaporanKegiatanRequest $request, $id)
    {
        $satpam =  Satpam::where('user_id', auth()->user()->id );
        $laporanQuery = LaporanKejadianSatpam::where('id', $id);

        if($request->file('bukti')) {
            $this->deleteBukti($id);
            $laporanQuery->update([
                'bukti' => $this->addBukti($request->bukti)
            ]);
        }

        $laporan = ['laporan_kejadian_id' => $id];
        if($request->saksi && $request->old_saksi) {
            foreach($request->saksi as $saksi) {
                foreach($request->old_saksi as $old_saksi) {
                    if(isset($saksi["id"])) {
                        if($saksi["id"] == $old_saksi["id"] ) {
                            SaksiLaporanSatpam::where('id', $old_saksi["id"])->update(array_merge($saksi, $laporan));
                        }
                    } else {
                        SaksiLaporanSatpam::create(array_merge($saksi, $laporan));
                    }
                }
            }
        } else if($request->saksi) {
            foreach($request->saksi as $saksi) {
                $saksi['laporan_kejadian_id'] = $id;
                SaksiLaporanSatpam::create(array_merge($saksi, $laporan));
            }
        } else if($request->old_saksi !== null) {
            foreach($request->old_saksi as $old_saksi) {
                SaksiLaporanSatpam::where('laporan_kejadian_id', $old_saksi["id"])->delete();
                LaporanKejadianSatpam::where('id', $id )->decrement('jumlah_saksi');
            }
        }

        $laporanQuery->update($request->except('_token', '_method'));
        $this->flashSuccess('Berhasil Mengupdate Laporan');
        return redirect()->route('satpam.laporan-kejadian.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->deleteBukti($id);
            LaporanKejadianSatpam::destroy($id);

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
}
