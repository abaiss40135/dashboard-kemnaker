<?php

namespace App\Http\Controllers\Bujp\TransaksiBujp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bujp\TransaksiBujp\StorePendaftaranSioRequest;
use App\Http\Requests\Bujp\TransaksiBujp\UpdatePendaftaranSioRequest;
use App\Mail\PendaftaranSioMail;
use App\Models\PendaftaranSio;
use App\Models\StatusSio;
use App\Services\Interfaces\NIBServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PendaftaranSioController extends Controller
{
    protected $nibService;

    /**
     * PendaftaranSioController constructor.
     */
    public function __construct(NIBServiceInterface $nibService)
    {
        $this->nibService = $nibService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (request()->ajax()){
            $query = PendaftaranSio::query()
                ->with('statusSio')
                ->where('bujp_id' , auth()->user()->bujp->id)->latest('id')
                ->orderByDesc('tanggal_pengajuan');

            return DataTables::eloquent($query)
                ->addColumn('action', function ($collection) {
                    return '<a href="' . route('transaksi.pendaftaran-sio.edit', ['pendaftaran_sio' => $collection->id]) . '" data-id="' . $collection->id . '" class="btn btn-sm btn-warning my-0"><i class="far fa-edit"></i></a>';
                })
                ->editColumn('jenis_usaha', function ($collection){
                    $check = json_decode($collection->jenis_usaha, true);
                    if ($check != null){
                        $html = '<ol>';
                        foreach ($check as $jenis) {
                            $html .= "<li>$jenis</li>";
                        }
                        return $html . '</ol>';
                    } else {
                        return str_replace(")", ")</em></b>", str_replace("(", "<b><em>(", $collection->jenis_usaha));
                    }
                })
                ->editColumn('tanggal_pengajuan', function ($sio){
                    return Carbon::parse($sio->tanggal_pengajuan)->translatedFormat('l, d F Y');
                })
                ->rawColumns(['action', 'status_sio.status', 'jenis_usaha'])
                ->toJson();
        }

        $data = [
            'status'    => StatusSio::orderBy('id')->pluck('status', 'id'),
            'status_terakhir' => PendaftaranSio::latest()->first('status')->status
        ];
        return view('bujp.transaksi-bujp.pendaftaran-sio.index', $data);
    }

    public function create()
    {
        $bujp = auth()->user()->bujp;
        $bidang_usaha = explode(',', $bujp->bidang_usaha);

        return view('bujp.transaksi-bujp.pendaftaran-sio.daftar', compact('bidang_usaha', 'bujp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePendaftaranSioRequest $request)
    {
        $bujp = auth()->user()->bujp;
        $this->uploadPath = 'bujp';
        $this->folderName = $bujp->nama_badan_usaha . '/' . 'sio' . '/' . Carbon::now()->translatedFormat(config('app.long_date_format')) . '/';

        DB::beginTransaction();
        try{
            $pendaftaranSio = new PendaftaranSio();
            $pendaftaranSio->bujp_id = $bujp->id;
            $pendaftaranSio->nib = $request->nib;
            $pendaftaranSio->nama_perusahaan = $request->nama_perusahaan;
            $pendaftaranSio->alamat = $request->alamat;
            $pendaftaranSio->jenis_usaha = json_encode($request->jenis_usaha);
            $pendaftaranSio->nama_polda = Arr::last(explode(',', $request->nama_polda));
            $pendaftaranSio->tanggal_pengajuan = now();
            $pendaftaranSio->save();

            foreach($request->berkas_pendaftaran_sio as $key => $gambar_file){
                $fileName = Str::slug($bujp->nama_badan_usaha) . '-' . $key . '.' . $gambar_file->getClientOriginalExtension();
                $this->fileName = $fileName;
                $pendaftaranSio->berkasPendaftaran()->create([
                    'nama' => $fileName,
                    'file' => $this->saveFiles($gambar_file),
                    'jenis_berkas' => $key
                ]);
            }
            Mail::to(auth()->user()->email)
                ->cc(config('mail.cc_email'))
                ->send(new PendaftaranSioMail($pendaftaranSio->nama_polda));

            $this->flashSuccess('Berhasil Menambahkan Pengajuan SIO Baru Kantor Pusat');
            DB::commit();
            return redirect()->route('transaksi.pendaftaran-sio.index');
        } catch (\Exception $e){
            DB::rollBack();
            $this->flashError($e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param PendaftaranSio $pendaftaranSio
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(PendaftaranSio $pendaftaranSio)
    {
        return view('bujp.transaksi-bujp.pendaftaran-sio.edit', ['data' => $pendaftaranSio->load('berkasPendaftaran.jenisBerkas')]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePendaftaranSioRequest $request
     * @param PendaftaranSio $pendaftaranSio
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePendaftaranSioRequest $request, PendaftaranSio $pendaftaranSio)
    {
        $this->uploadPath = 'bujp';
        $this->folderName = $pendaftaranSio->bujp->nama_badan_usaha . '/' . 'sio' . '/' . Carbon::now()->translatedFormat(config('app.long_date_format')) . '/';

        DB::beginTransaction();
        try{
            if ($request->has('berkas_pendaftaran_sio')){
                foreach($request->berkas_pendaftaran_sio as $key => $gambar_file){
                    $fileName = Str::slug($pendaftaranSio->bujp->nama_badan_usaha) . '-' . $key . '.' . $gambar_file->getClientOriginalExtension();
                    $this->fileName = $fileName;
                    $pendaftaranSio->berkasPendaftaran()->where('jenis_berkas', $key)->update([
                        'nama' => $fileName,
                        'file' => $this->saveFiles($gambar_file),
                        'jenis_berkas' => $key
                    ]);
                }
            }
            DB::commit();
            $this->flashSuccess('Data Pendaftaran SIO Berhasil Diperbarui!');
            return redirect()->route('transaksi.pendaftaran-sio.index');
        } catch (\Exception $exception){
            DB::rollBack();
            $this->flashError($exception->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
